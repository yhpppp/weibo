<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */

    /**
     * 自动授权默认会假设 Model 模型文件直接存放在 app 目录下，鉴于* 我们已将模型存放目录修改为 app/Models，接下来还需自定义自动授* 权注册的规则，修改 boot() 方法：
     */
    public function boot()
    {
        $this->registerPolicies();
        
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            // 动态返回模型对应的策略名称，如：// 'App\Model\User' => 'App\Policies\UserPolicy',
            return 'App\Policies\\' . class_basename($modelClass) . 'Policy';
        });
    }
}
