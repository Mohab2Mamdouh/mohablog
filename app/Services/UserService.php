<?php

namespace App\Services;

use App\Http\Requests\PersonalInfoRequest;
use App\Http\Requests\ProfileImageRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function getFirst(): ?Model
    {
        return $this->userRepository->getFirst();
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function update(PersonalInfoRequest $request): ?Model
    {
        $data = $request->validated();
        $user = $this->getFirst();
        return $this->userRepository->update($user->id, $data);
    }

    public function updateProfileImage(ProfileImageRequest $request): ?Model
    {
        $user = $this->getFirst();

        $photo = $user->username . '-' . time() . '.' . $request->profile_pic->extension();
        $request->profile_pic->move(public_path('storage/users'), $photo);

        return $this->userRepository->update($request->id, [
            'profileImage' => $photo,
        ]);
    }
}

