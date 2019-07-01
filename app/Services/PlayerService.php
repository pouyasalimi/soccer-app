<?php

namespace App\Services;

use App\Http\Requests\PlayerRequest;
use App\Repositories\PlayerRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PlayerService extends Service
{

    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    /**
     * PlayerService constructor.
     *
     * @param PlayerRepository $playerRepository
     */
    public function __construct(PlayerRepository $playerRepository)
    {
        parent::__construct();
        $this->playerRepository = $playerRepository;
    }

    /**
     * @param PlayerRequest $request
     *
     * @return bool
     */
    public function create(PlayerRequest $request) {
        return $this->playerRepository->create($request->all());
    }

    /**
     * @return PlayerRepository[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all() {
        return $this->playerRepository->all();
    }

    /**
     * @param $id
     *
     * @return PlayerRepository|PlayerRepository[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function show($id) {
        return $this->playerRepository->findOrFail($id);
    }

    /**
     * @param PlayerRequest $request
     * @param $id
     *
     * @return mixed
     */
    public function update(PlayerRequest $request, $id) {

        if(isset(parse_url($request->picture)['scheme'])) {
            $request->merge(['picture' => basename($request->picture)]);
        }
        return $this->playerRepository->update(
            $id,
            $request->only(['picture']),
            $request->only(['name', 'email', 'password'])
        );
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function destroy($id) {
        return $this->playerRepository->destroy($id);
    }

    /**
     * resize and save image in storage
     * @param $picture
     *
     * @return string
     */
    public function handlePicture($picture) {

        $picture = $this->convertBase64toImage($picture);
        $pictureName = Str::uuid() .'.'.'png';
        Storage::put( 'public/pictures/' . $pictureName, base64_decode($picture) );
        $image = Image::make( storage_path('app/public/pictures/' . $pictureName) );
        $image->fit( 100, 100, function ( $constraint ) {
            $constraint->aspectRatio();
        } );
        Storage::put( 'public/pictures/' . $pictureName, (string) $image->encode() );

        return $pictureName;
    }

    /**
     * handle base64 image and convert it to image
     * @param $picture
     *
     * @return mixed
     */
    private function convertBase64toImage($picture) {
        $picture = str_replace('data:image/png;base64,', '', $picture);
        $picture = str_replace(' ', '+', $picture);
        return $picture;
    }
}
