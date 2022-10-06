<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "restaurante".
 *
 * @property int $id
 * @property string $nit
 * @property string $nombre
 * @property string $telefono
 * @property string $celular
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
 * @property string|null $logo
 *
 * @property Grupo[] $grupos
 * @property Menu[] $menus
 * @property Pedido[] $pedidos
 * @property SubGrupo[] $subGrupos
 * @property User $usuario
 */
class Restaurante extends \yii\db\ActiveRecord
{
    public $archivo;
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
            [['total_mesas', 'mensualidad', 'codigo_de_activacion', 'activado', 'usuario_id'], 'integer'],
            [['fecha'], 'safe'],
            [['nit', 'nombre', 'telefono', 'celular', 'email', 'encargado', 'direccion', 'ciudad', 'hora'], 'string', 'max' => 250],
            [['archivo'], 'file', 'extensions' => 'jpg,png'],
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
            'archivo' => 'Logo',
        ];
    }

    /**
     * Gets query for [[Grupos]].
     *
     * @return \yii\db\ActiveQuery|GrupoQuery
     */
    public function getGrupos()
    {
        return $this->hasMany(Grupo::class, ['restaurante_id' => 'id']);
    }

    /**
     * Gets query for [[Menus]].
     *
     * @return \yii\db\ActiveQuery|MenuQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::class, ['restaurante_id' => 'id']);
    }

    /**
     * Gets query for [[Pedidos]].
     *
     * @return \yii\db\ActiveQuery|PedidoQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::class, ['restaurante_id' => 'id']);
    }

    /**
     * Gets query for [[SubGrupos]].
     *
     * @return \yii\db\ActiveQuery|SubGrupoQuery
     */
    public function getSubGrupos()
    {
        return $this->hasMany(SubGrupo::class, ['restaurante_id' => 'id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
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
