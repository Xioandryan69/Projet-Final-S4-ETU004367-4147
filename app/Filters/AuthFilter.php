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

        $authOperateur = in_array('operateur', (array) $arguments, true);
        $estConnecte = $authOperateur
            ? $session->get('operateur_connecte') === true && (int) $session->get('operateur_type_id') > 0
            : $session->get('connecte') === true && (int) $session->get('compte_id') > 0;

        if ($estConnecte) {
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

        return redirect()->to($authOperateur ? '/operateur/login' : '/login')
            ->with('error', 'Vous devez vous connecter.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
