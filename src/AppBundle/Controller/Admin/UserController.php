<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class UserController
 *
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 *
 * @Route("/admin/users")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="all_users")
     *
     * @Method("GET")
     *
     * @Template()
     */
    public function indexAction()
    {
        $allUsers = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findAll();

        if (!$allUsers) {
            throw $this->createNotFoundException('Пользователи не найдены');
        }

        foreach ($allUsers as $key => $user) {
            if ($user->hasRole('ROLE_SUPER_ADMIN')) {
                unset($allUsers[$key]);
            }
        }

        return [
            'users' => $allUsers,
        ];
    }

    /**
     * @param User $user
     *
     * @return array
     *
     * @Route("/{id}", name="admin_show_user")
     *
     * @ParamConverter("user", class="AppBundle:User")
     *
     * @Template()
     */
    public function showAction(User $user)
    {
        return [
            'user' => $user,
        ];
    }

    /**
     * @param User $user
     *
     * @Route("/add_role_admin/{id}", name="add_role_admin")
     *
     * @ParamConverter("user", class="AppBundle:User")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|void
     */
    public function addRoleAdminAction(User $user)
    {
        if (!$user->hasRole('ROLE_ADMIN')) {
            $user->addRole('ROLE_ADMIN');
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash(
                'notice',
                'Роль пользователя была изменена.'
            );
        }

        return $this->redirectToRoute('admin_show_user', ['id' => $user->getId()]);
    }

    /**
     * @param User $user
     *
     * @Route("/remove_role_admin/{id}", name="remove_role_admin")
     *
     * @ParamConverter("user", class="AppBundle:User")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeRoleAdminAction(User $user)
    {
        if ($user->hasRole('ROLE_ADMIN')) {
            $user->removeRole('ROLE_ADMIN');
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash(
                'notice',
                'Роль пользователя была изменена.'
            );
        }

        return $this->redirectToRoute('admin_show_user', ['id' => $user->getId()]);
    }

    /**
     * @param User $user
     *
     * @Route("/lock/{id}", name="lock_user")
     *
     * @ParamConverter("user", class="AppBundle:User")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function lockAction(User $user)
    {
        if (!$user->isLocked()) {
            $user->setLocked(true);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash(
                'notice',
                'Пользователь заблокирован.'
            );
        }

        return $this->redirectToRoute('admin_show_user', ['id' => $user->getId()]);


    }

    /**
     * @param User $user
     *
     * @Route("/unlock/{id}", name="unlock_user")
     *
     * @ParamConverter("user", class="AppBundle:User")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function unlockAction(User $user)
    {
        if ($user->isLocked()) {
            $user->setLocked(false);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash(
                'notice',
                'Пользователь разблокирован.'
            );
        }

        return $this->redirectToRoute('admin_show_user', ['id' => $user->getId()]);

    }

    /**
     * @param User $user
     *
     * @Route("/remove/{id}", name="remove_user")
     *
     * @ParamConverter("user", class="AppBundle:User")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(User $user)
    {
        $userManager = $this->get('fos_user.user_manager');
        $userManager->deleteUser($user);

        $this->addFlash(
            'notice',
            'Пользователь успешно удален.'
        );

        return $this->redirectToRoute('all_users');
    }
}
