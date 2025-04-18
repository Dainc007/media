<?php

declare(strict_types=1);

namespace App\Filament\Pages\Auth;

use App\Filament\Resources\UserResource;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

final class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                UserResource::getAvatarFileUploadComponent(),
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
