<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "restaurante".
 *
 * @property int $id
 * @property int $nit
 * @property string $nombre
 * @property int $telefono
 * @property int $celular
 * @property string $email
 * @property string $encargado
 * @property string $direccion
 * @property string $ciudad
 * @property int $total_mesas
 * @property int $mensualidad
 * @property int $codigo_de_activacion
 * @property int $activado
 * @property int $usuario_id
 * @property string $fecha
 * @property string $hora
 *
 * @property User $usuario
 */
class Restaurante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nit', 'nombre', 'telefono', 'celular', 'email', 'encargado', 'direccion', 'ciudad', 'total_mesas', 'mensualidad', 'codigo_de_activacion', 'activado', 'usuario_id', 'fecha', 'hora'], 'required'],
            [['nit', 'telefono', 'celular', 'total_mesas', 'mensualidad', 'codigo_de_activacion', 'activado', 'usuario_id'], 'integer'],
            [['fecha'], 'safe'],
            [['nombre', 'email', 'encargado', 'direccion', 'ciudad', 'hora'], 'string', 'max' => 250],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nit' => 'Nit',
            'nombre' => 'Nombre',
            'telefono' => 'Telefono',
            'celular' => 'Celular',
            'email' => 'Email',
            'encargado' => 'Encargado',
            'direccion' => 'Direccion',
            'ciudad' => 'Ciudad',
            'total_mesas' => 'Total Mesas',
            'mensualidad' => 'Mensualidad',
            'codigo_de_activacion' => 'Codigo De Activacion',
            'activado' => 'Activado',
            'usuario_id' => 'Usuario ID',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
        ];
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::class, ['id' => 'usuario_id']);
    }

    /**
     * {@inheritdoc}
     * @return RestauranteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RestauranteQuery(get_called_class());
    }
}
