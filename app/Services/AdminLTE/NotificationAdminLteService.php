<?php

namespace App\Services\AdminLTE;

use App\Models\Persona;
use Illuminate\Support\Str;

class NotificationAdminLteService
{
    /**
     * @param iterable<\App\Models\Notification> $notifications
     */
    public function getHtmlNotifications($notifications): array
    {

        $dropdown_html = '';

        foreach ($notifications as $key => $notification) {

            $persona = Persona::find($notification->codigo);

            if ($key < 5) {
                $text = Str::limit($notification->text, 15);
                $icon = "<i class='mr-2 {$notification->icon} fa-sm'></i>";

                $time = "<span class='float-right text-muted text-sm'>
                    {$notification->created_at->diffForHumans()}
                    </span>";
//$dropdown_html .= "<a class='dropdown-item text-sm callout callout-".$notification->alert."' style='margin-bottom: 0.1rem' href='#'>            
                $href = "href='".route('admin.personas.show', $persona)."'";
                $dropdown_html .= "<a class='dropdown-item text-sm callout callout-".$notification->alert."' style='margin-bottom: 0.1rem' ".$href.">            
                
                            {$icon}{$text}{$time}
                            </a>";

                //if ($key < count($notifications) - 1) {
                // $dropdown_html .= "<div class='dropdown-divider'></div>";
                //}
            }
        }

        // Return the new notification data.

        return [
            'label'       => count($notifications),
            'label_color' => 'danger',
            'icon_color'  => 'white',
            'dropdown'    => $dropdown_html,
        ];
    }
}
