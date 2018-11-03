<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Crumbs;

Breadcrumbs::register('home', function (Crumbs $crumbs) {
    $crumbs->push('Home', route('home'));
});

Breadcrumbs::register('login', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Login', route('login'));
});

Breadcrumbs::register('register', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Register', route('register'));
});

Breadcrumbs::register('password.request', function (Crumbs $crumbs) {
    $crumbs->parent('login');
    $crumbs->push('Reset Password', route('password.request'));
});

Breadcrumbs::register('password.reset', function (Crumbs $crumbs) {
    $crumbs->parent('password.request');
    $crumbs->push('Change', route('password.reset'));
});

Breadcrumbs::register('cabinet', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Cabinet', route('cabinet'));
});

Breadcrumbs::register('verification.notice', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Verify', route('verification.notice'));
});

Breadcrumbs::register('verification.verify', function (Crumbs $crumbs, $id) {
    $crumbs->parent('home');
    $crumbs->push('Verify', route('verification.verify'));
});

Breadcrumbs::register('verification.resend', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Verify', route('verification.resend'));
});

Breadcrumbs::register('admin.home', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Admin', route('admin.home'));
});