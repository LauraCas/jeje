<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[LocalesEtiquetas]].
 *
 * @see LocalesEtiquetas
 */
class LocalesEtiquetasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return LocalesEtiquetas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LocalesEtiquetas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    //funcion para buscar todas las etiquetas asociadas a un id de etiqueta

    public function etiqueta($id){

        return $this
            ->andWhere(['etiqueta_id' => $id]);
    }
}
