<?php
namespace Huoban\Models;

use Huoban\Helpers\CurlHttp;

class HuobanUser
{

    /**
     * get
     *
     * @return array
     */
    public static function get()
    {
        return CurlHttp::post("/user");
    }

    public static function getUser($space_id, $attributes = array())
    {
        return CurlHttp::get("/space/{$space_id}/members", $attributes);
    }

    public static function find($attributes = array())
    {
        return CurlHttp::post("/users/find", $attributes);
    }

    public static function getCompanyUser($company_id, $attributes = [])
    {
        return CurlHttp::post("/company_members/company/{$company_id}", $attributes);
    }
    // 企业工作区成员 和角色组 
    public static function getMembersGroups($space_id, $attributes)
    {
        return CurlHttp::get("/members_and_groups/space/{$space_id}", $attributes);
    }
    // 添加成员到角色组
    public static function addMembersGroups($space_member_group_id, $attributes = [])
    {
        return CurlHttp::put("/space_member_group/{$space_member_group_id}/move_in", $attributes);
    }
}
