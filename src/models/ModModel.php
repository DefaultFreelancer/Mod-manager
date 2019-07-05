<?php


namespace ItVision\ModManager\models;


use Pterodactyl\Models\Egg;

class ModModel extends BaseModel
{
    protected $table = 'mods';

    protected $fillable = [
        'name',
        'description',
        'version',
        'category_id',
        'path',
        'link',
        'author',
        'game',
        'foldername'
    ];
    // only one mod can be in a category

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ModCategoryModel::class);
    }


    public function getEggNameById($id)
    {
        $egg = Egg::find($id);
        return $egg->name;
    }

}
