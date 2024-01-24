<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application".
 *
 * @property int $id
 * @property int $user_id
 * @property int $status_id
 * @property int $category_id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string|null $image_admin
 * @property string|null $reason
 * @property string $created_at
 *
 * @property Category $category
 * @property Status $status
 * @property User $user
 */
class Application extends \yii\db\ActiveRecord
{
    const SCENARIO_APPLY = 'apply';
    const SCENARIO_CANCEL = 'cancel';

    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'category_id', 'title', 'description'], 'required'],
            // [['user_id', 'status_id', 'category_id'], 'integer'],
            [['created_at'], 'safe'],
            [['title', 'description', 'image', 'image_admin', 'reason'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'on' => self::SCENARIO_APPLY],
            ['reason', 'required', 'on' => self::SCENARIO_CANCEL]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Номер пользователя',
            'status_id' => 'Статус',
            'category_id' => 'Категория',
            'title' => 'Название',
            'description' => 'Описание',
            'image' => 'Изображение пользователя',
            'image_admin' => 'Изображение администратора',
            'reason' => 'Ответ админа',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function upload($field = 'image')
    {
        if ($this->validate()) {
            $fileName = Yii::$app->user->identity->id
            . '_'
            . time()
            . '.'
            . $this->imageFile->extension
            ;
            $this->imageFile->saveAs('img/' . $fileName);
            $this->$field = $fileName;
            return true;
        } else {
            return false;
        }
    }
}
