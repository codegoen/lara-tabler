<?php

namespace Rizkhal\Tabler\Console\Commands\Concerns;

trait Handler {

    /**
     * Execute the console command.
     *
     * @return bool|null
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        // First we need to ensure that the given name is not a reserved word within the PHP
        // language and that the class name will actually be valid. If it is not valid we
        // can error now and prevent from polluting the filesystem using invalid files.
        if ($this->isReservedName($this->getNameInput())) {

            $reserved = "The name {$this->getNameInput} of {$this->type} is reserved by PHP.";

            $this->error($reserved);

            return false;
        }

        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);

        // Check method exists in all object has this trait
        if (method_exists($this, 'getCheckDataTable')) {
            // Check incoming request datatables exists or not
            if (! is_null($this->getOption('datatables'))) {
                // Check force update datatable exists or not
                if ((! $this->hasOption('force') ||
                    ! $this->option('force')) &&
                    $this->getCheckDataTable()) {

                    $existsMessages = "DataTable ".$this->getOption('model-name')."DataTable already exists!";

                    $this->error($existsMessages);

                    session()->put(['type' => 'danger', 'message' => $existsMessages]);

                    return false;
                }
            }
        }

        // Next, We will check to see if the class already exists. If it does, we don't want
        // to create the class and overwrite the user's code. So, we will bail out so the
        // code is untouched. Otherwise, we will continue generating this class' files.
        if ((! $this->hasOption('force') ||
             ! $this->option('force')) &&
             $this->alreadyExists($this->getNameInput())) {

            $existsMessages = "{$this->type} {$this->getNameInput()} already exists!";

            $this->error($existsMessages);

            session()->put(['type' => 'danger', 'message' => $existsMessages]);

            return false;
        }

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($name)));

        $successMessage = "{$this->type} {$this->getNameInput()} created successfully.";

        $this->info($successMessage);

        session()->put(['type' => 'success', 'message' => $successMessage]);    
    }

    /**
     * Get option
     * 
     * @param  string $option
     * @return string|void
     */
    protected function getOption(string $option)
    {
        if (! is_null($options = $this->option($option))) {
            return trim($options);
        }
    }
}
