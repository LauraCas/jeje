<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios_area_moderacion".
 *
 * @property int $id
 * @property int $usuario_id Usuario relacionado con un Area para su moderación.
 * @property int $zona_id Zona relacionada con el Usuario que puede moderarla.
 */
class UsuariosAreaModeracion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'usuario_id' => 'Usuario',
            'zona_id'    => 'Area de Moderacion',
            'zona'       => 'Area de Moderación',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UsuariosAreaModeracionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsuariosAreaModeracionQuery(get_called_class());
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }

    /**
     * @return mixed
     */
    public function getZona()
    {
        return $this->hasOne(Zonas::className(), ['id' => 'zona_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'zona_id'], 'required'],
            [['usuario_id', 'zona_id'], 'integer'],
            [['usuario', 'zona'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios_area_moderacion';
    }
}
