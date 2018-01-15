<?php

/**
 * StoreImage form request to more easily validate the image upload
 * 
 * PHP Version 7.1
 * 
 * @category HttpFormRequest
 * @package  PhotoGallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv
 * @link     https://github.com/stobbsm/photogallery3
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Checksum;
use App\File;
use Illuminate\Support\Facades\Storage;

/**
 * Run validation on image uploads.
 * 
 * @category Class
 * @package  PhotoGallery
 * @author   Matthew Stobbs <matthew@sproutingcommuniations.com>
 */
class StoreImage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'required',
        ];
    }

    /**
     * Validate the file checksum before committing it.
     * 
     * @param Illuminate\Validation\Validator $validator the Validator object
     * 
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(
            function ($validator) {
                $tmpPath = Storage::disk('tmp')->putFile('', $this->image);
                $checksum = hash('sha256', Storage::disk('tmp')->get($tmpPath));
                Storage::disk('tmp')->delete($tmpPath);
                if (File::where('checksum', $checksum)->get()->isNotEmpty()) {
                    $validator->errors()->add('checksum', 'File already exists');
                }
            }
        );
    }
}
