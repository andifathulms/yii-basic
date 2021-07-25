<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "districts".
 *
 * @property string $id
 * @property string $regency_id
 * @property string $name
 *
 * @property Regencies $regency
 * @property Villages[] $villages
 */
class Districts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'districts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'regency_id', 'name'], 'required'],
            [['id'], 'string', 'max' => 7],
            [['regency_id'], 'string', 'max' => 4],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['regency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regencies::className(), 'targetAttribute' => ['regency_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'regency_id' => 'Regency ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Regency]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegency()
    {
        return $this->hasOne(Regencies::className(), ['id' => 'regency_id']);
    }

    /**
     * Gets query for [[Villages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVillages()
    {
        return $this->hasMany(Villages::className(), ['district_id' => 'id']);
    }

    public static function getKelurahan($regencesID, $dependent = false)
    {
        // $subCategory = self::find()
        // ->select(['prodi as name', 'id'])
        // ->where(['id_fakultas' => $fakultasID])
        // ->asArray()
        // ->all();

        // return $subCategory;

        $subCategory = self::find()->where(['regency_id'=> $regencesID]);
        if ($dependent=="") {
            #$jancuk = $subCategory->select(['id','name as name'])->asArray()->all();
            #var_dump($subCategory->select(['id','name as name'])->asArray()->all());
            return $subCategory->select(['id','name as name'])->asArray()->all();
        } else {
            return $subCategory->select(['name'])->indexBy('id')->column();
        }
    }
}
