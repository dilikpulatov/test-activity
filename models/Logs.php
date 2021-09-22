<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%logs}}".
 *
 * @property int $id
 * @property string|null $url
 * @property string|null $date
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'logs';
    }

    public static function fromKey($key = 'l'): string
    {
        return 'logs as '.$key;
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['url', 'required'],
            [['date'], 'datetime'],
            [['url'], 'string', 'max' => 250],
        ];
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class'      => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['date']
                ],
                "value" => date('Y-m-d H:i:s')
            ],
        ];
    }

    public static function getFields(int $limit, int $page): array
    {
        $offset = $page > 1 ? $limit * ($page - 1) : 0;

        $query = self::find()
          ->select([
            'MAX(id) as id',
            'COUNT(id) as count',
            'url',
            'MAX(date) as date'
          ])
          ->orderBy('date DESC')
          ->groupBy(['url']);

         $pagination = (clone($query))->count();

        $query = $query->limit($limit)
          ->offset($offset)
          ->asArray()
          ->all();

        return [
            "list" => $query,
            "total" => $pagination,
            "page" => $page
        ];
    }

    public static function setField($data): array
    {
        $query = new self();
        $query->attributes = $data;
        if ($query->save()) {
            return [
               "id" => $query->id,
               "url" => $query->url,
               "date" => $query->date
            ];
        } else {
            return [
              "errors" => $query->getErrors()
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'date' => 'Date',
        ];
    }
}
