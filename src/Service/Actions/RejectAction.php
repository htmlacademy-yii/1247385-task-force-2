<?php

namespace Taskforce\Service\Actions;

use Taskforce\Logic\Task;

class RejectAction extends BaseAction
{

    protected string $actionName = 'Отказаться от задания';
    protected string $actionCode = Task::ACTION_FINISH;

    public static function checkAccess(Task $task, int $userId): bool
    {
        if ($task->getCurrentStatus() !== $task::STATUS_ACTIVE) {
            return false;
        }

        return $userId === $task->getWorkerId();
    }
}
