<?php


namespace ItVision\ModManager\models;


class ModCategoryModel extends BaseModel
{

    protected $table = 'mod_categories';

    protected $with = ['mods'];

    protected $fillable = [
        'title',
        'description'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mods()
    {
        return $this->hasMany(ModModel::class,'category_id','id');
    }




}
