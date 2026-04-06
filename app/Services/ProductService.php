<?php

namespace App\Services;

use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function handleStore(array $data)
    {
        return DB::transaction(function () use ($data) {
            $product = Products::create($data);

            $product->subCategories()->sync($data['sub_category_ids']);
            $product->tags()->sync($data['tag_ids'] ?? []);

            if (isset($data['main_image'])) {
                $this->uploadFile($product, $data['main_image'], true);
            }

            if (isset($data['other_images'])) {
                foreach ($data['other_images'] as $file) {
                    $this->uploadFile($product, $file, false);
                }
            }

            return $product;
        });
    }

    public function handleUpdate(Products $product, array $data)
    {
        return DB::transaction(function () use ($product, $data) {

            $product->update($data);

            if (isset($data['sub_category_ids'])) {
                $product->subCategories()->sync($data['sub_category_ids']);
            }

            $product->tags()->sync($data['tag_ids'] ?? []);

            if (isset($data['main_image'])) {
                $this->deleteOldMainImage($product);
                $this->uploadFile($product, $data['main_image'], true);
            }

            if (isset($data['other_images'])) {
                foreach ($data['other_images'] as $file) {
                    $this->uploadFile($product, $file, false);
                }
            }

            return $product->load(['subCategories', 'tags', 'images']);
        });
    }

    private function uploadFile($product, $file, $isMain)
    {
        $mime = $file->getMimeType();
        $fileType = 'image';

        if (str_contains($mime, 'video')) {
            $fileType = 'video';
        } elseif (str_contains($mime, 'pdf')) {
            $fileType = 'pdf';
        }

        $folder = "products/{$fileType}s";
        $path = $file->store($folder, 'public');

        $product->images()->create([
            'path' => $path,
            'file_type' => $fileType,
            'is_main' => $isMain
        ]);
    }

    private function deleteOldMainImage($product)
    {
        $oldImage = $product->images()->where('is_main', true)->first();
        if ($oldImage) {
            Storage::disk('public')->delete($oldImage->path);
            $oldImage->delete();
        }
    }
}
