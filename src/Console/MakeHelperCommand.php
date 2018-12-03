<?php

namespace BoomDraw\Helpers\Console;

use Exception;
use StrHelper;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\DetectsApplicationNamespace;

class MakeHelperCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:helper {classname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new helper class with facade';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle()
    {
        $classname = studly_case($this->argument('classname'));
        $classname = ends_with($classname, 'Helper') ? $classname : $classname . 'Helper';
        $namespace = str_replace(DIRECTORY_SEPARATOR, '\\', StrHelper::utrim(config('helpers.path')));
        $namespace = $this->getAppNamespace() . $namespace;
        $path = app_path(config('helpers.path'));
        $cpath = $path . DIRECTORY_SEPARATOR . $classname . '.php';
        if (!empty($fdir = config('helpers.facade_dir'))) {
            $fclassname = $classname;
            $fnamespace = $namespace . '\\' . $fdir;
            $fpath = $path . DIRECTORY_SEPARATOR . $fdir . DIRECTORY_SEPARATOR . $fclassname . '.php';
        } else {
            $fclassname = $classname . 'Facade';
            $fnamespace = $namespace;
            $fpath = $path . DIRECTORY_SEPARATOR . $fclassname . '.php';
        }

        $this->checkExistance($cpath);
        $this->checkExistance($fpath);
        file_put_contents($cpath, $this->getClass($classname, $namespace));
        file_put_contents($fpath, $this->getFacade($fclassname, $fnamespace));
        $this->info("$classname successfully created!");
    }

    /**
     * @param $path
     * @throws Exception
     */
    private function checkExistance($path)
    {
        $filesystem = new Filesystem;
        if ($filesystem->exists($path)) {
            throw new Exception("$path already exists!");
        }
    }

    private function getFacade($classname, $namespace)
    {
        return "<?php

namespace $namespace;

use Illuminate\Support\Facades\Facade;
use BoomDraw\Helpers\Traits\ServiceNameGetter;

class $classname extends Facade
{
    use ServiceNameGetter;

    protected static function getFacadeAccessor() { return self::getServiceName(); }
}
";
    }

    private function getClass($classname, $namespace)
    {
        return "<?php

namespace $namespace;

class $classname
{
    //
}
";
    }
}
