<?php

namespace App\Http\Controllers\User;

use File;
use Image;
use Storage;
use Response;
use App\Avatar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AvatarController extends Controller
{
    /**
     * Avatar page.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function avatar()
    {
        return view('users.avatar.show');
    }

    /**
     * Store the avatar.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function store(Request $request)
    {
    	$file = $request->file('avatar');

		$originalFilename = $file->getClientOriginalName();
		$fileExtension = $file->extension();
		$filepath = $file->path();
		$mimeType = $file->getMimeType();
		$filepath = Storage::putFile('avatar', $file);
		$filename = $file->hashName();

		Avatar::updateOrCreate(['user_id' => auth()->user()->id],
		[
			'original_file_name' => $originalFilename,
	        'file_name' => $filename,
	        'file_path' => $filepath,
	        'file_extension' => $fileExtension,
	        'mime_type' => $mimeType,
	        'user_id' => auth()->user()->id,
		]);

		return redirect()->route('users.show', auth()->user()->id);
    }

    /**
     * Show the file.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function image($filename)
    {
        $path = storage_path('app/avatar/' . $filename);

        return $this->generateFileResponse($path);
    }

    /**
     * Generate file response.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function generateFileResponse($path)
    {
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
