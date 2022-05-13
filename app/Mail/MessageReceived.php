<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Member;
use App\Project;


class MessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $members;
    public $project;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Project $project)
    {
        $this->project=$project;
        $this->members = Member::where("project_id", $project->id)->with(["info.water", "dependents.relationship", "materialWalls"])->get();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view("project.2022.pdf");
        //return $this->view('view.name');
        //return $this->view('mails.mail');
    }
}
