<?php
namespace CreativeCommunityAI\xenforouserintegration\models;

use craft\base\Model;

class Settings extends Model
{
    public string $dbHost = '';
    public string $dbName = '';
    public string $dbUsername = '';
    public string $dbPassword = '';

    public function rules(): array
    {
        return [
            [['dbHost', 'dbName', 'dbUsername', 'dbPassword'], 'required'],
        ];
    }
}