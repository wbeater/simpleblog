<?php

require_once (Yii::getAlias('@vendor/fzaninotto/faker/src/autoload.php'));
use yii\db\Migration;
use app\models\User;
use app\models\Post;

/**
 * Class m180824_234026_create_dummy_data
 * @property Facker\Generator $faker Description
 */
class m180824_234026_create_dummy_data extends Migration
{
    public $faker;
    public function init() {
        parent::init();
        $this->faker = Faker\Factory::create();
    }
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $admin = new User();
        $admin->setScenario('create');
        $admin->username = 'admin';
        $admin->password = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->status = User::STATUS_ACTIVE;
        $admin->is_admin = 1;
        
        if (!$admin->save()) {
            throw new Exception('Create admin error: ' . json_encode($admin->getFirstErrors()));
        }
          
        $demo = new User();
        $demo->setScenario('create');
        $demo->username = 'demo';
        $demo->password = 'demo';
        $demo->email = 'demo@gmail.com';
        $demo->status = User::STATUS_ACTIVE;
        $demo->is_admin = 0;
        
        if (!$demo->save()) {
            throw new Exception('Create admin error: ' . json_encode($demo->getFirstErrors()));
        }
        
        $users = [$admin->id, $demo->id];
        
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setScenario('create');
            $user->username = 'user' . $i;
            $user->password = 'user' . $i;
            $user->email = 'user' . $i . '@gmail.com';
            $user->status = User::STATUS_ACTIVE;
            $user->is_admin = 0;

            if (!$user->save()) {
                throw new Exception('Create user error: ' . json_encode($user->getFirstErrors()));
            }
            
            $users[] = $user->id;
        }
        
        for ($i=0; $i<100; $i++) {
            $post = new Post();
            $post->title = $this->faker->paragraph(1);
            $post->summary = $this->faker->paragraphs(2, true);
            $post->content = '<p>' . implode("</p><p>", $this->faker->paragraphs(20, false)) . '</p>';
            $post->thumbnail_url = $this->faker->imageUrl(200, 200, null, true);
            $post->image_url = $this->faker->imageUrl(1024, 800, null, true);
            $post->status = 1;
            $post->published_time = strtotime('-2 days') + mt_rand(0, 5 * 24 * 60 * 60);
            $post->created_by = $post->updated_by = $users[array_rand($users)];
            if (!$post->save()) {
                throw new Exception('Create post error: ' . json_encode($post->getFirstErrors()));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180824_234026_create_dummy_data cannot be reverted.\n";
        return false;
    }
}
