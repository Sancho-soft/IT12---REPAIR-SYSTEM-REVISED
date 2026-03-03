<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryService
{
    /**
     * Upload a profile picture and return [url, public_id]
     */
    public static function uploadProfilePicture($file, ?string $oldPublicId = null): array
    {
        // Delete old image if replacing
        if ($oldPublicId) {
            try {
                Cloudinary::destroy($oldPublicId);
            }
            catch (\Exception $e) {
            // Silently fail - old image deletion is not critical
            }
        }

        $result = Cloudinary::upload($file->getRealPath(), [
            'folder' => 'Repairshop101/profile_pictures',
            'transformation' => [
                'width' => 400,
                'height' => 400,
                'crop' => 'fill',
                'gravity' => 'face',
                'quality' => 'auto',
            ],
        ]);

        return [
            'url' => $result->getSecurePath(),
            'public_id' => $result->getPublicId(),
        ];
    }

    /**
     * Upload a service report attachment and return [url, public_id, original_name, resource_type]
     */
    public static function uploadAttachment($file): array
    {
        $resourceType = in_array($file->getClientOriginalExtension(), ['pdf', 'doc', 'docx'])
            ? 'raw'
            : 'image';

        $result = Cloudinary::upload($file->getRealPath(), [
            'folder' => 'Repairshop101/service_attachments',
            'resource_type' => $resourceType,
            'quality' => 'auto',
        ]);

        return [
            'url' => $result->getSecurePath(),
            'public_id' => $result->getPublicId(),
            'original_name' => $file->getClientOriginalName(),
            'resource_type' => $resourceType,
        ];
    }

    /**
     * Delete a file from Cloudinary
     */
    public static function delete(string $publicId, string $resourceType = 'image'): void
    {
        try {
            Cloudinary::destroy($publicId, ['resource_type' => $resourceType]);
        }
        catch (\Exception $e) {
        // Silently fail
        }
    }
}
