<?php

namespace Awobaz\Laracraft\Console\Commands;

use Awobaz\Laracraft\Models\Layout\Region;
use Awobaz\Laracraft\Models\Layout\Theme;
use Awobaz\Laracraft\Util;
use Exception;
use Illuminate\Support\Facades\DB;

class InstallThemes extends Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laracraft:install-themes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install layout region info in database';

    /**
     * Views' path.
     *
     * @var string
     */
    private $viewsPath;

    public function __construct()
    {
        parent::__construct();
        $this->viewsPath = resource_path().DIRECTORY_SEPARATOR.'views';
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        //Util::getDefinedBlockComponents();

        try {
            $this->infoWithTimestamp('Installing themes...');

            $themesPath = config('laracraft.theme_paths') ?: [];

            $themesPath = array_map(function($path) {
                return $this->viewsPath.DIRECTORY_SEPARATOR.$path;
            }, $themesPath);

            DB::beginTransaction();

            DB::statement('TRUNCATE TABLE laracraft_layout_regions');

            foreach($themesPath as $path){
                $this->installThemeFromPath($path);
            }

            DB::commit();

            $this->infoWithTimestamp('Themes were installed successfully.');
        } catch(Exception $e){
            DB::rollBack();
            $this->errorWithTimestamp('An error occurred: '.$e->getMessage());
        }
    }

    private function installThemeFromPath($path)
    {
        $themeExtension = ".blade.php";

        $themeFiles = glob($path."/*".$themeExtension);

        $themeKeys = array_map(function($theme) use ($themeExtension) {
            $themeKey = basename($theme);
            $themeKey = str_replace($themeExtension, '', $themeKey);

            return $themeKey;
        }, $themeFiles);

        $themes = array_combine($themeKeys, $themeFiles);

        foreach($themes as $key => $file) {
            $theme = Theme::firstOrCreate([
                'path' => $file
            ], [
                'relative_path' => str_replace($this->viewsPath.DIRECTORY_SEPARATOR, '', $file)
            ]);

            //Register theme's regions
            $themeContent = file_get_contents($file);

            if (preg_match_all('/@region\([\'|"](.*)[\'|"]\)/ie', $themeContent, $matches)) {
                $regions = collect($matches[1]);

                $regions->each(function ($name) use ($theme) {
                    $region = new Region();
                    $region->name = $name;

                    $theme->regions()->save($region);
                });
            }

            $this->infoWithTimestamp('Installed '.$file);
        }
    }
}
