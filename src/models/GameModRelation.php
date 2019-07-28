<?php
/**
 * Created by PhpStorm.
 * User: miliv
 * Date: 7/11/2019
 * Time: 2:24 PM
 */

namespace ItVision\ModManager\models;


class GameModRelation extends BaseModel
{
    protected $table = 'game_mod_relation';
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'egg_id',
        'mod_id'
    ];



}