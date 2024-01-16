<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $merchant_id;

    public function __construct()
    {
        $this->merchant_id = $this->checkDomain();
    }

    protected function checkDomain()
    {
        $url = request()->getHost();
        if (
            \strpos($url, 'livekala') !== false
        ) {
            $urlArray = \explode('.', $url);

            $prefix = \explode('//', $urlArray[0]);

            $domain = \end($prefix);
        } else
            $domain = $url;
        $merchant_id = Merchant::where('domain', $domain)->get()->toArray();

        return ($merchant_id !== []) ? $merchant_id[0]['id'] : 0;
    }
}
