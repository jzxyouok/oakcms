<?php
/**
 * Copyright (c) 2015 - 2016. Hryvinskyi Volodymyr
 */

namespace app\modules\shop\models;

use yii;

/**
 * Class Price
 * @package app\modules\shop\models
 * @property $id
 * @property $name
 * @property $product_id
 * @property $price
 * @property $type_id
 * @property $amount
 * @property $sort
 */
class Price extends \yii\db\ActiveRecord implements \app\modules\cart\interfaces\CartElement
{

    public static function tableName()
    {
        return '{{%shop_price}}';
    }

    public function rules()
    {
        return [
            [['name', 'product_id'], 'required'],
            [['name', 'available', 'code'], 'string', 'max' => 100],
            [['price'], 'number'],
            [['product_id', 'amount', 'type_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'product_id' => 'Продукт',
            'price' => 'Цена',
            'code' => 'Артикул',
            'available' => 'Наличие',
            'amount' => 'Остаток',
            'type_id' => 'Тип цены',
            'sort' => 'Приоритет',
        ];
    }

    public function minusAmount($count)
    {
        $this->amount = $this->product->amount-$count;

        return $this->save(false);
    }

    public function plusAmount($count)
    {
        $this->amount = $this->product->amount+$count;

        return $this->save(false);
    }

    public function getCartId() {
        return $this->id;
    }

    public function getCartName() {
        return $this->product->name;
    }

    public function getCartPrice() {
        return $this->price;
    }

    public function getCartOptions()
    {
        return '';
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public static function editField($id, $name, $value)
    {
        $setting = Price::findOne($id);
        $setting->$name = $value;
        $setting->save();
    }
}
