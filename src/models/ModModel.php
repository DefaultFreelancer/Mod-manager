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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ModCategoryModel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gamesRelation()
    {
        return $this->hasMany(GameModRelation::class, 'mod_id', 'id');
    }

    /**
     * @return array
     */
    public function games()
    {
        $return = [];
        foreach ($this->gamesRelation as $relation)
        {
            array_push($return, Egg::find($relation->egg_id));
        }
        return $return;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getEggNameById($id)
    {
        $egg = Egg::find($id);
        return $egg->name;
    }

    /**
     * @param $request
     */
    public function updateRelations($request)
    {
        if(count($request['games']))
        {
            GameModRelation::where(['mod_id' => $this->id])->delete();
            foreach ($request['games'] as $game)
            {
                GameModRelation::create(['mod_id' => $this->id, 'egg_id' => $game]);
            }
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function doesItHave($id)
    {
        if(GameModRelation::where(['egg_id' => $id, 'mod_id' => $this->id])->first()){
            return true;
        }
        return false;
    }

}
