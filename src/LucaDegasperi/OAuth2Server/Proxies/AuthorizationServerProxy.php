<?php namespace LucaDegasperi\OAuth2Server\Proxies;

use League\OAuth2\Server\Authorization as Authorization;
use League\OAuth2\Server\Util\RedirectUri;
use League\OAuth2\Server\Exception\ClientException;
use Exception;
use Response;
use Input;
use DB;

class AuthorizationServerProxy
{
    /**
     * The OAuth authorization server
     * @var [type]
     */
    protected $authServer;

    /**
     * Create a new AuthorizationServerProxy
     * 
     * @param Authorization $authServer the OAuth Authorization Server to use
     */
    public function __construct(Authorization $authServer)
    {
        $this->authServer = $authServer;
    }

    /**
     * Pass the method call to the underlying Authorization Server
     * 
     * @param  string $method the method being called
     * @param  array|null $args the arguments of the method being called
     * @return mixed the underlying method retuned value
     */
    public function __call($method, $args)
    {
        switch (count($args)) {
            case 0:
                return $this->authServer->$method();
            case 1:
                return $this->authServer->$method($args[0]);
            case 2:
                return $this->authServer->$method($args[0], $args[1]);
            case 3:
                return $this->authServer->$method($args[0], $args[1], $args[2]);
            case 4:
                return $this->authServer->$method($args[0], $args[1], $args[2], $args[3]);
            default:
                return call_user_func_array(array($this->authServer, $method), $args);
        }
    }

    /**
     * Make a redirect to a client redirect URI
     * @param  string $uri            the uri to redirect to
     * @param  array  $params         the query string parameters
     * @param  string $queryDelimeter the query string delimiter
     * @return Redirect               a Redirect object
     */
    public function makeRedirect($uri, $params = array(), $queryDelimeter = '?')
    {
        return RedirectUri::make($uri, $params, $queryDelimeter);
    }

    /**
     * Make a redirect with an authorization code
     * 
     * @param  string $code   the authorization code of the redirection
     * @param  array  $params the redirection parameters
     * @return Redirect       a Redirect object
     */
    public function makeRedirectWithCode($code, $params = array())
    {
        return $this->makeRedirect($params['redirect_uri'], array(
            'code'  =>  $code,
            'state' =>  isset($params['state']) ? $params['state'] : '',
        ));
    }

    /**
     * Make a redirect with an error
     * 
     * @param  array  $params the redirection parameters
     * @return Redirect       a Redirect object
     */
    public function makeRedirectWithError($params = array())
    {
        return $this->makeRedirect($params['redirect_uri'], array(
            'message' =>  $this->authServer->getExceptionMessage('access_denied'),
            'state' =>  isset($params['state']) ? $params['state'] : ''
        ));
    }

    /**
     * Check the authorization code request parameters
     * 
     * @throws \OAuth2\Exception\ClientException
     * @return array Authorize request parameters
     */
    public function checkAuthorizeParams()
    {
        return $this->authServer->getGrantType('authorization_code')->checkAuthoriseParams();
    }

    /**
     * Authorize a new client
     * @param  string $owner    The owner type
     * @param  string $owner_id The owner id
     * @param  array  $options  Additional options to issue an authorization code
     * @return string           An authorization code
     */
    public function newAuthorizeRequest($owner, $owner_id, $options)
    {
        return $this->authServer->getGrantType('authorization_code')->newAuthoriseRequest($owner, $owner_id, $options);
    }

    /**
     * Deauthorize client by deleting session data on oauth_sessions table
     * @param  string $owner    The owner type
     * @param  string $owner_id The owner id
     * @return bool             Success or not
     */
    public function deleteSession($owner, $owner_id) {
        return DB::table('oauth_sessions')
            ->where('owner_type', $owner)
            ->where('owner_id', $owner_id)
            ->delete();
    }

    /**
     * Perform the access token flow
     * 
     * @return Response the appropriate response object
     */
    public function performAccessTokenFlow()
    {
        try {

            // Get user input
            $input = Input::all();

            // Tell the auth server to issue an access token
            $response = $this->authServer->issueAccessToken($input);

        } catch (ClientException $e) {

            // Throw an exception because there was a problem with the client's request
            $response = array(
                'code' =>  $this->authServer->getExceptionType($e->getCode()),
                'error_description' => $e->getMessage()
            );

            // make this better in order to return the correct headers via the response object
            $headers = $this->authServer->getExceptionHttpHeaders($this->authServer->getExceptionType($e->getCode()));
            foreach ($headers as $header) {
                // @codeCoverageIgnoreStart
                header($header);
                // @codeCoverageIgnoreEnd
            }

        } catch (Exception $e) {

            // Throw an error when a non-library specific exception has been thrown
            $response = array(
                'code' =>  500,
                'message' => $e->getMessage()
            );

            return $response;
        }

        return $response;
    }
}
