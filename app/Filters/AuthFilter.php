<?php
namespace App\Filters;
use App\Models\UsersModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use  App\Models\RoleModel;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request ,$arguments =null)
    {
        $session = session();

        if(!$session->get('logged_in'))
        {
            return redirect()->to('/login')->with('error','Vous devez vous connecter.');
        }
        if(!empty($arguments))
            {
            
                $userId=$session->get('id');
                $user= new UsersModel();
                $userRole= $user->getRole($userId);

                $role =$userRole['role_name'] ;

                $allowedRoles = [];
                foreach ($arguments as $arg) {
                    foreach (explode(',', $arg) as $r) {
                        $allowedRoles[] = trim($r);
                    }
                }
                if (!in_array($role, $allowedRoles, true)) {

                    switch ($role) {
                        case 'admin': return redirect()->to(site_url('admin/dashboard'));
                        case 'rh':    return redirect()->to(site_url('rh/dashboard'));
                        case 'user':    return redirect()->to(site_url('rh/dashboard'));
                        default:      return redirect()->to(site_url('users/login'));
                    }
                }
                //lol



            }
        
    }

    public function after(RequestInterface $request, ResponseInterface $response,$arguments= null)
    {

    }
}