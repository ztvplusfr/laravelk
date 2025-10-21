<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class SupabaseStorageService
{
    protected $bucketName;
    protected $storagePath;
    protected $publicUrl;
    protected $endpoint;

    public function __construct()
    {
        $this->bucketName = config('supabase.storage.bucket', 'ztvplusfr');
        $this->storagePath = 'avatars/';
        $this->publicUrl = config('supabase.storage.public_url');
        $this->endpoint = config('supabase.storage.endpoint');
    }

    /**
     * Upload un fichier vers Supabase Storage
     *
     * @param UploadedFile $file
     * @param string $fileName
     * @return string|false
     */
    public function upload(UploadedFile $file, string $fileName)
    {
        try {
            // Vérifier et créer le dossier avatars s'il n'existe pas
            if (!Storage::exists($this->storagePath)) {
                Storage::makeDirectory($this->storagePath);
            }

            // Générer un nom de fichier unique
            $uniqueFileName = $this->generateUniqueFileName($file, $fileName);
            $filePath = $this->storagePath . $uniqueFileName;

            // Stocker le fichier localement temporairement
            $storedPath = $file->storeAs('temp', $uniqueFileName, 'local');

            if (!$storedPath) {
                return false;
            }

            // Obtenir le contenu du fichier
            $fileContent = file_get_contents(storage_path('app/' . $storedPath));
            
            // Construire l'URL complète
            $publicUrl = rtrim($this->publicUrl, '/') . '/' . $this->bucketName . '/' . $filePath;
            
            // Supprimer le fichier temporaire
            unlink(storage_path('app/' . $storedPath));
            
            return $publicUrl;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'upload vers Supabase: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprime un fichier de Supabase Storage
     *
     * @param string $fileUrl
     * @return bool
     */
    public function delete(string $fileUrl): bool
    {
        try {
            // Extraire le chemin du fichier depuis l'URL
            $path = parse_url($fileUrl, PHP_URL_PATH);
            $pathParts = explode($this->bucketName . '/', $path);
            
            if (count($pathParts) < 2) {
                return false;
            }
            
            $filePath = $pathParts[1];
            
            // Supprimer le fichier local s'il existe
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression du fichier: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Génère un nom de fichier unique
     *
     * @param UploadedFile $file
     * @param string $baseName
     * @return string
     */
    protected function generateUniqueFileName(UploadedFile $file, string $baseName): string
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = str_slug(pathinfo($baseName, PATHINFO_FILENAME));
        $fileName = $fileName . '-' . time() . '.' . $extension;
        
        return $fileName;
    }
}
