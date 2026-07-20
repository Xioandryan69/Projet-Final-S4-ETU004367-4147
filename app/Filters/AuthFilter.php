<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if ($session->get('connecte') === true && (int) $session->get('compte_id') > 0) {
            return null;
        }

        if ($request->isAJAX()) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Votre session a expiré. Veuillez vous reconnecter.',
                ]);
        }

        return redirect()->to('/login')->with('error', 'Vous devez vous connecter.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
