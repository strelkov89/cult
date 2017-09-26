<?php

namespace app\models;

use app\models\Project;
use app\models\ProjectRequest;
use app\models\user\Profile;
use app\models\user\User;
use Exception;
use Yii;

class ProjectManager
{
    public $message = '';

    /**
     * 
     * @param string $activation_code
     * @return Registration model
     * @throws Exception
     */
    public function userCanJoinProject(Profile $userProfile, Project $project)
    {
        // Создал свой проект
        if ($this->userHasOwnProject($userProfile->user->id)) {
            $this->message = 'Присоедениться к  проекту нельзя. У Вас уже есть свой собственный проект.';
            return false;
        }

        // Заявка уже подана
        if ($this->userHasRequestToProject1($userProfile, $project)) {
            $this->message = 'Ваша заявка принята. Владелец проекта получил уведомление и в скором времени рассмотрит вашу заявку.';
            return false;
        }
        
        // Заявка уже подана
        if ($this->userHasRequestToProject2($userProfile, $project)) {
            $this->message = 'Вы являетесь участником этого проекта.';
            return false;
        }
        
        // Заявка уже подтверждена
        if ($this->userHasConfirmedRequest($userProfile->user_id)) {
            $this->message = 'Разрешается участие только в одном проекте.';
            return false;
        }

        // Тербуются другие специалисты
        if (!$this->userHasProjectPosition($userProfile, $project)) {
            $this->message = 'Присоедениться к  проекту нельзя. Данному проекту требуются другие специалисты.';
            return false;
        }
        return true;
    }

    /**
     * 
     * @param string $userId
     * return true|false
     */
    public function userCanCreateProject($userId)
    {
        // Участник проекта
        if ($this->userHasConfirmedRequest($userId)) {
            $this->message = 'Создать проект нельзя. Вы уже являетесь участником другого проекта.';
            return false;
        }

        // Создал свой проект
        if ($this->userHasOwnProject($userId)) {
            $this->message = 'Создать проект нельзя. У Вас уже есть свой собственный проект.';
            return false;
        }
        return true;
    }

    public function userCanJoinToAnyProjects($userId)
    {
        // Создал свой проект
        if ($this->userHasOwnProject($userId)) {
            $this->message = 'Вступать в проекты нельзя. У Вас уже есть свой собственный проект.';
            return false;
        }
        return true;
    }

    /**
     * 
     * @param string $userId
     * return true|false
     */
    private function userHasRequest($userId)
    {
        if (ProjectRequest::findOne(['user_id' => $userId]))
            return true;
        return false;
    }

    /**
     * 
     * @param string $userId
     * return true|false
     */
    public function userHasConfirmedRequest($userId)
    {
        if (ProjectRequest::findOne(['user_id' => $userId, 'status' => ProjectRequest::STATUS_CONFIRMED]))
            return true;
        return false;
    }

    /**
     * 
     * @param string $userId
     * @return boolean
     */
    public function userHasOwnProject($userId)
    {
        if ($this->getUserProject($userId))
            return true;
        return false;
    }

    /**
     * 
     * @param Profile $userProfile
     * @param Project $project
     * @return boolean
     */
    private function userHasRequestToProject(Profile $userProfile, Project $project)
    {
        if (ProjectRequest::findOne(['user_id' => $userProfile->user_id, 'project_id' => $project->id]))
            return true;
        return false;
    }
    
    /**
     * 
     * @param Profile $userProfile
     * @param Project $project
     * @return boolean
     */
    private function userHasRequestToProject1(Profile $userProfile, Project $project)
    {
        if (ProjectRequest::findOne(['user_id' => $userProfile->user_id, 'project_id' => $project->id, 'status' => ProjectRequest::STATUS_NEW]))
            return true;
        return false;
    }
    
    /**
     * 
     * @param Profile $userProfile
     * @param Project $project
     * @return boolean
     */
    public function userHasRequestToProject2(Profile $userProfile, Project $project)
    {
        if (ProjectRequest::findOne(['user_id' => $userProfile->user_id, 'project_id' => $project->id, 'status' => ProjectRequest::STATUS_CONFIRMED]))
            return true;
        return false;
    }

    /**
     * 
     * @param Profile $userProfile
     * @param Project $project
     * @return boolean
     */
    private function userHasProjectPosition(Profile $userProfile, Project $project)
    {
        // Проекту не нужны 
        if (
            ($project->need_coder && $userProfile->is_coder) ||
            ($project->need_designer && $userProfile->is_designer) ||
            ($project->need_ux && $userProfile->is_ux)
        )
            return true;
        return false;
    }

    /**
     * 
     * @param string $userId
     * @return Project model|null
     */
    public function getUserProject($userId)
    {
        return Project::findOne(['author_id' => $userId]);
    }

    /**
     * 
     * @param Project $project
     * @return Project
     */
    public function prepareProject(Project $project)
    {
        $project->author_id = Yii::$app->user->identity->id;
        if ($project->isNewRecord) {
            $project->status = Project::STATUS_NEW;
        }
        if ($project->status === 'moderate') {
            $project->status = Project::STATUS_MODERATE;
        }

        return $project;
    }

    /**
     * 
     * @param ProjectRequest $request
     * @return ProjectRequest
     */
    public function prepareRequest(ProjectRequest $request)
    {
        $request->user_id = Yii::$app->user->identity->id;
        $request->project_id = Yii::$app->request->post('projectId');
        $request->status = ProjectRequest::STATUS_NEW;
        return $request;
    }

    /**
     * 
     * @param Profile $userProfile
     * @param Project $project
     * @return boolean
     * @throws Exception
     */
    public function confirmRequest(Profile $userProfile, Project $project)
    {
        $request = ProjectRequest::findOne([
                'user_id' => $userProfile->user_id,
                'project_id' => $project->id,
                'status' => ProjectRequest::STATUS_NEW
        ]);
        if ($request) {
            $request->status = ProjectRequest::STATUS_CONFIRMED;
            if ($request->update()) {
                return true;
            }
            throw new Exception('ProjectRequest can not be updated');
        }
        throw new Exception('ProjectRequest can not be find');
    }

    /**
     * 
     * @param Profile $userProfile
     */
    public function deleteAllUsersRequest(Profile $userProfile)
    {
        $conditions = [
            "user_id" => $userProfile->user_id,
            "status" => [ProjectRequest::STATUS_NEW, ProjectRequest::STATUS_REJECTED]
        ];

        ProjectRequest::deleteAll($conditions);
    }

    /**
     * 
     * @param Profile $userProfile
     * @param Project $project
     * @return boolean
     * @throws Exception
     */
    public function rejectRequest(Profile $userProfile, Project $project)
    {
        $request = ProjectRequest::findOne([
                'user_id' => $userProfile->user_id,
                'project_id' => $project->id,
                //'status' => ProjectRequest::STATUS_CONFIRMED
        ]);

        if ($request) {
            //$request->status = ProjectRequest::STATUS_REJECTED;
            if ($request->delete()) {
                return true;
            }
            throw new Exception('ProjectRequest can not be updated');
        }
        throw new Exception('ProjectRequest can not be find');
    }

    /**
     * 
     * @param Profile $userProfile
     * @param Project $project
     * @return true|false
     */
    public function alertUserThatRequestConfirmed(Profile $userProfile, Project $project)
    {
        return Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['email'])
                ->setTo($userProfile->user->email)
                ->setSubject('Ваша заявка на участие в проекте подтверждена.')
                ->setHtmlBody('Ваша заявка на участие в проекте "'.$project->title.'" подтверждена'
                    .'<br><br>Команда Apps4All<br>')
                ->send();
    }

    /**
     * 
     * @param Profile $userProfile
     * @param Project $project
     * @return true|false
     */
    public function alertUserThatRequestReject(Profile $userProfile, Project $project)
    {
        return Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['email'])
                ->setTo($userProfile->user->email)
                ->setSubject('Ваша заявка на участие в проекте отклонена.')
                ->setHtmlBody('Ваша заявка на участие в проекте "'.$project->title.'" отклонена'
                    .'<br><br>Команда Apps4All<br>')
                ->send();
    }
    
        /**
     * 
     * @param Profile $userProfile
     * @param Project $project
     * @return true|false
     */
    public function alertUserAboutNewRequest(Profile $userProfile, Project $project)
    {
        $projectUser = User::findOne(['id' => $project->author_id]);
        if ($projectUser)
            $projectEmail = $projectUser->email;
        else
            return false;
                
        return Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['email'])
                ->setTo($projectEmail)
                ->setSubject('На Ваш проект поступила новая заявка.')
                ->setHtmlBody('На Ваш проект "'.$project->title.'" поступила новая заявка'
                    .'<br><br>Команда Apps4All<br>')
                ->send();
    }

    /**
     * 
     * @param Project $project
     * @return boolean
     */
    public function userCanChangeProject(Project $project)
    {
        return (Project::STATUS_NEW === $project->status);
    }
    
    public function projectNotUseEntireLimit($project){
        $count = ProjectRequest::find()->where("(status = 2) and (project_id = $project->id)")->count();
            if ( $count < 5 ) {
                return true;
            }
        return false;
    }

}
