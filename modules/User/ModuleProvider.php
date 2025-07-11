<?php
namespace Modules\User;
use App\Helpers\ReCaptchaEngine;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Modules\ModuleServiceProvider;
use Modules\Vendor\Models\VendorRequest;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(CustomFortifyAuthenticationProvider::class);
    }

    public static function getAdminMenu()
    {
        $noti_verify = User::countVerifyRequest();
        $noti_upgrade = VendorRequest::where('status', 'pending')->count();
        $noti = $noti_verify;

        $options = [
            "position"=>100,
            'url'        => route('user.admin.index'),
            'title'      => __('Users :count',['count'=>$noti ? sprintf('<span class="badge badge-warning">%d</span>',$noti) : '']),
            'icon'       => 'icon ion-ios-contacts',
            'permission' => 'user_view',
            'children'   => [
                'user'=>[
                    'url'   => route('user.admin.index'),
                    'title' => __('All Users'),
                    'icon'  => 'fa fa-user',
                ],
                'role'=>[
                    'url'        => route('user.admin.role.index'),
                    'title'      => __('Role Manager'),
                    'permission' => 'role_view',
                    'icon'       => 'fa fa-lock',
                ],
                'subscriber'=>[
                    'url'        => route('user.admin.subscriber.index'),
                    'title'      => __('Subscribers'),
                    'permission' => 'newsletter_manage',
                ],
                'userUpgradeRequest'=>[
                    'url'        => route('user.admin.upgrade'),
                    'title'      => __('Upgrade Request :count',['count'=>$noti_upgrade ? sprintf('<span class="badge badge-warning">%d</span>',$noti_upgrade) : '']),
                    'permission' => 'user_view',
                ],
            ]
        ];

        $is_disable_verification_feature = setting_item('user_disable_verification_feature');
        if(empty($is_disable_verification_feature)){
            $options['children']['user_verification'] = [
                'url'        => route('user.admin.verification.index'),
                'title'      => __('Verification Request :count',['count'=>$noti_verify ? sprintf('<span class="badge badge-warning">%d</span>',$noti_verify) : '']),
                'permission' => 'user_view',
            ];
        }

        return [
            'users'=> $options
        ];
    }
    public static function getUserMenu()
    {
        /**
         * @var $user User
         */
        $res = [];
        $user = Auth::user();

        // $is_wallet_module_disable = setting_item('wallet_module_disable');
        // if(empty($is_wallet_module_disable))
        // {
        //     $res['wallet']= [
        //         'position'   => 27,
        //         'icon'       => 'fa fa-money',
        //         'url'        => route('user.wallet'),
        //         'title'      => __("My Wallet"),
        //     ];
        // }

        $is_disable_verification_feature = setting_item('user_disable_verification_feature');
        if(!empty($user->verification_fields) and empty($is_disable_verification_feature))
        {
            $res['verification']= [
                'url'        => route('user.verification.index'),
                'title'      => __("Verifications"),
                'icon'       => 'fa fa-handshake-o',
                'position'   => 39,
            ];
        }

        $res['enquiry']= [
            'position'   => 37,
            'icon'       => 'icofont-ebook',
            'url'        => route('vendor.enquiry_report'),
            'title'      => __("Enquiry Report"),
            'permission' => 'enquiry_view',
        ];

        if(setting_item('inbox_enable')) {
            $count = auth()->user()->unseen_message_count;
            $res['chat'] = [
                'position' => 20,
                'icon' => 'fa fa-comments',
                'url' => route('user.chat'),
                'title' => __("Messages :count",['count'=>$count ? sprintf('<span class="badge badge-danger">%d</span>',$count) : '']),
            ];
        }
        if(setting_item('user_enable_2fa'))
        {
            $res['chat'] = [
                'position' => 51,
                'icon' => 'fa fa-lock',
                'url' => route('user.2fa'),
                'title' => __("2F Authentication"),
            ];
        }

        return $res;
    }
}
