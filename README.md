<h1 align="center"> laravel_lin_cms </h1>

# 简介

## 什么是 Lin CMS？

> Lin-CMS 是林间有风团队经过大量项目实践所提炼出的一套**内容管理系统框架**。Lin-CMS 可以有效的帮助开发者提高 CMS 的开发效率。 本项目是基于Laravel 9的 Lin CMS 后端实现。

官方团队产品了解请访问[TaleLin](https://github.com/TaleLin)

## Lin CMS 的特点

Lin CMS 的构筑思想是有其自身特点的。下面我们阐述一些 Lin 的主要特点。

**Lin CMS 是一个前后端分离的 CMS 解决方案**

首先，传统的网站开发更多的是采用服务端渲染的方式，需用使用一种模板语言在服务端完成页面渲染：比如 JinJa2、Jade 等。 服务端渲染的好处在于可以比较好的支持 SEO，但作为内部使用的 CMS 管理系统，SEO 并不重要。

但一个不可忽视的事实是，服务器渲染的页面到底是由前端开发者来完成，还是由服务器开发者来完成？其实都不太合适。现在已经没有多少前端开发者是了解这些服务端模板语言的，而服务器开发者本身是不太擅长开发页面的。那还是分开吧，前端用最熟悉的 Vue
写 JS 和 CSS，而服务器只关注自己的 API 即可。

其次，单页面应用程序的体验本身就要好于传统网站。

更多关于Lin CMS的介绍请访问[Lin CMS线上文档](https://doc.cms.talelin.com/)

**框架本身已内置了 CMS 常用的功能**

Lin 已经内置了 CMS 中最为常见的需求：用户管理、权限管理、日志系统等。开发者只需要集中精力开发自己的 CMS 业务即可

## 所需基础

由于 Lin 采用的是前后端分离的架构，所以你至少需要熟悉 PHP 和 Vue。

Lin 的服务端框架是基于 laravel的，所以如果你比较熟悉laravel的开发模式，那将可以更好的使用本项目。但如果你并不熟悉laravel，我们认为也没有太大的关系，因为框架本身已经提供了一套完整的开发机制，你只需要在框架下用
PHP 来编写自己的业务代码即可。照葫芦画瓢应该就是这种感觉。

但前端不同，前端还是需要开发者比较熟悉 Vue 的。但我想以 Vue 在国内的普及程度，绝大多数的开发者是没有问题的。这也正是我们选择 Vue 作为前端框架的原因。

# 快速开始

## Server 端必备环境

* 安装MySQL（version： 5.7+）

* 安装PHP环境(version： 8.0+)

## 安装

```shell
$ composer require pyjhyssc/laravel_lin_cms 
```

## 使用

- 执行以下命令初始化

```shell
php artisan cms:install
```

- 运行上面命令后，修改config/auth.php配置文件,在guards里追加admin配置,在providers数组里追加Admins配置

```
'guards' => [

    ...
    
    'admin' => [
        'driver' => 'sanctum',
        'provider' => 'admins',
        ]
    ],

...

'providers' => [
        
        ...
        
        'admins' => [
            'driver' => 'eloquent',
            'model' => \Lincms\Models\LinUser::class,
        ],
    ],
```

- 权限配置文件在config/permission,修改里面permission数组需执行```php artisan cms:init_Permission```
  才能生效，注意（分组权限中间表会清空，需重新关联分组权限）;要为路由设置权限只需修改url_permission数组,格式：控制器=>[方法=>权限]，
- 例：

```
'url_permission' => [
        BookController::class => ['index' => '图书管理', 'store' => '添加图书', 'update' => '编辑图书', 'destroy' => '删除图书']
    ],
];
```