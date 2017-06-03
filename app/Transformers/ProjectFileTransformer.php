<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectFile;

/**
 * Class ProjectFileTransformer
 * @package namespace CodeProject\Transformers;
 */
class ProjectFileTransformer extends TransformerAbstract
{

    /**
     * Transform the \ProjectFile entity
     * @param \ProjectFile $model
     *
     * @return array
     */
    public function transform(ProjectFile $o)
    {
        return [
            'id' => $o->id,
            'project_id' => $o->project_id,
            'name' => $o->name,
            'extension' => $o->extension,
            //'extension' => $this->imagemExtencao($o),
            'description' => $o->description,
            'excluido' => $o->excluido
        ];
    }

    public function imagemExtencao(ProjectFile $projectFile)
    {
        if ($projectFile->extension == 'jpg') {
            return ['formato' => 'jpg', 'image' => 'build/images/icons/ico-jpg.png'];
        }
    }
}
