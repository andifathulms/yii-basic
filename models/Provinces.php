<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provinces".
 *
 * @property string $id
 * @property string $name
 *
 * @property Regencies[] $regencies
 */
class Provinces extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provinces';
    }

    public static function getProv()
    {
        return Self::find()->select(['name', 'id'])->indexBy('id')->column();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Regencies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegencies()
    {
        return $this->hasMany(Regencies::className(), ['province_id' => 'id']);
    }

    public function getProvinces()
    {
        return $this->hasOne(Provinces::className(), ['id' => 'id_
            provinsi']);
    }
}
