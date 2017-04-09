<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectNote;

/**
 * Class ProjectNoteTransformer
 * @package namespace CodeProject\Transformers;
 */
class ProjectNoteTransformer extends TransformerAbstract
{

    /**
     * Transform the \ProjectNote entity
     * @param \ProjectNote $model
     *
     * @return array
     */
    public function transform(ProjectNote $projectNote)
    {
        return [
            'id'         => (int) $projectNote->id,
            'project_id' => $projectNote->project_id,
            'title'      => $projectNote->title,
            'note'       => $projectNote->note,
            'created_at' => $projectNote->created_at,
            'updated_at' => $projectNote->updated_at
        ];
    }
}
