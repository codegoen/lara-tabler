<?php

namespace Rizkhal\Tabler\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class TablerRequestCommand extends GeneratorCommand
{
    use Concerns\Handler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tabler:request 
                            {name : The name of the request.}
                            {--authorized= : The authorized of the request.}
                            {--field-rules= : The field and validation of the incoming requests.}
                            {--force : Overwrite already existing request.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Request';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = "Request";

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/Presents/tabler-crud-stubs/request.stub';
    }

    /**
     * Get default namespace 
     * 
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . "\\Http\\Requests";
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $fieldRules = $this->option('field-rules');
        $authorized = $this->getOption('authorized');

        return $this
                ->replaceNamespace($stub, $name)
                ->replaceAuthorized($stub, $authorized)
                ->replaceFieldRules($stub, $fieldRules)
                ->replaceClass($stub, $name);
    }

    protected function replaceFieldRules(&$stub, $fieldRules): self
    {
        foreach ($fieldRules as $i => $field) {
            $fields[] = explode("#", $field);
        }

        $data = '';
        $rules = '';
        foreach ($fields as $i) {
            $rules .= <<<EOD
            '$i[0]' => '$i[1]',\n\t\t\t
            EOD;
            $data .= <<<EOD
            '$i[0]' => \$this->$i[0],\n\t\t\t
            EOD;
        }

        $rules = substr($rules, 0, -5); // remove last tabs, enter and comma
        $data = substr($data, 0, -5); // remove last tabs, enter and comma

        $stub = str_replace('{{rules}}', $rules, $stub);
        $stub = str_replace('{{data}}', $data, $stub);

        return $this;
    }

    protected function replaceAuthorized(&$stub, $authorized): self
    {
        $stub = str_replace('{{bool}}', $authorized, $stub);

        return $this;
    }
}
