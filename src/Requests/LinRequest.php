<?php

namespace Lincms\Requests;

class LinRequest extends Request
{
    public function rules(): array
    {
        return match (request()->route()->getActionMethod()) {
            'updatePassword' => [
                'old_password' => 'required|current_password:admin',
                'new_password' => 'required',
                'confirm_password' => 'required',
            ],
            'createGroup' => [
                'info' => 'required',
                'name' => 'required',
                'permission_ids' => 'array',
            ],
            'updateGroup' => [
                'info' => 'required',
                'name' => 'required',
            ],
            'dispatchPermissions' => [
                'permission_ids' => 'array',
                'group_id' => 'required',
            ],
            'register' => [
                'username' => 'required|unique:lin_user',
                'password' => 'required',
                'confirm_password' => 'required',
                'email' => 'email',
                'group_ids' => 'array',
            ],
            'changeUserPassword' => [

                'password' => 'required',
                'confirm_password' => 'required',
            ],
            'updateUser' => [
                'group_ids' => 'array',
            ],
            default => [],
        };
    }
}
