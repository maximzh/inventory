<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 16.03.16
 * Time: 12:05
 */

namespace AppBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;


class OAuthUserProvider extends BaseFOSUBProvider
{

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {

        $username = $response->getUsername();
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));
        //when the user is registrating
        if (null === $user) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set'.ucfirst($service);
            $setter_id = $setter.'Id';
            $setter_token = $setter.'AccessToken';
            // create new user here
            $user = $this->userManager->createUser();
            $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());

            //switch ($service) {
            //    case 'google':
            //        $refreshToken = $response->getRefreshToken();
            //        $user->setGoogleRefreshToken($refreshToken);
            //        break;
            //}
            //I have set all requested data with the user's username
            //modify here with relevant data
            $user->setUsername($response->getEmail());
            $user->setEmail($response->getEmail());
            $user->setRealName($response->getRealName());

            $user->setPassword($username);
            $user->setEnabled(true);
            $this->userManager->updateUser($user);

            return $user;
        }
        //if user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set'.ucfirst($serviceName).'AccessToken';
        //update access token
        $user->$setter($response->getAccessToken());

        return $user;
    }

}