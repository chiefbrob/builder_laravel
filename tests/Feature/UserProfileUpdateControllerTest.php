<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserProfileUpdateControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateUserProfile()
    {
        $user = User::factory()->create([
            'name' => 'Mark',
            'phone_number' => 323232332383
        ]);
        $this->actingAs($user);
        $this->post(route('v1.user.update', ['user_id' => $user->id,]), [
            'name' => 'Makori',
            'phone_number' => 3232423233
        ])->assertOk();
        $this->assertDatabaseHas('users', [
            'name' => 'Makori',
            'phone_number' => 3232423233,
            'phone_number_verified_at' => null
        ]);
    }

    public function testAvatarUpdate()
    {
        $this->actingAsRandomUser();
        Storage::fake('local');
        $this->post(route('v1.user.update', ['user_id' => $this->user->id,]), [
            'name' => 'Makori2',
            'phone_number' => 123456,
            'photo' => UploadedFile::fake()->image('avatar.jpg')
        ])->assertOk();
        
        $this->user->refresh();

        $this->assertNotNull($this->user->photo);

        Storage::disk('local')
            ->assertExists("public/images/profile/".$this->user->photo);

            $this->assertDatabaseHas('users', [
                'name' => 'Makori2',
                'phone_number' => 123456,
                'photo' => $this->user->photo,
            ]);
        $oldPic = $this->user->photo;
        
        $this->post(
            route('v1.user.update', ['user_id' => $this->user->id,]), [
                'name' => 'Makori3',
                'phone_number' => 7891234,
                'photo' => UploadedFile::fake()->image('profile.jpeg')
            ]
        )->assertOk();

        $this->user->refresh();

        $this->assertNotNull($this->user->photo);
        $this->assertNotEquals($this->user->photo, $oldPic);


        Storage::disk('local')
            ->assertExists("public/images/profile/".$this->user->photo);

            $this->assertDatabaseHas('users', [
                'name' => 'Makori3',
                'phone_number' => 7891234,
                'photo' => $this->user->photo,
            ]);

            
        Storage::disk('local')->assertMissing("public/images/profile/$oldPic");
    }
}
