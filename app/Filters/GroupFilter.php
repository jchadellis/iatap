<?php 
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class GroupFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $user = auth()->user();
        log_message('debug', 'GroupFilter triggered');
        // If no user or not in the required group
        if (! $user || ! $user->inGroup($arguments[0])) {
            // Send group name to error page
            return redirect()
                ->to('access/denied')
                ->with('denied_group', $arguments[0]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing here
    }
}