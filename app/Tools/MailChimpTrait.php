<?php

namespace App\Tools;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Exceptions\SomethingWentWrong;
use App\Exceptions\NotEnable;

trait MailChimpTrait
{

    public function fullSet($email, $name, $last_name)
    {
        if (ENV('MAIL_CHIMP_ENABLE')) {
            $nombres = isset($name) ? $name : " ";
            $apellidos = isset($last_name) ? $last_name : " ";
            $this->createContact($email, $nombres, $apellidos);
            $this->subscribeContact($email);
            $this->tagContact($email);
        } else {
            throw new NotEnable();
        }
    }

    public function createContact($email, $name, $last_name)
    {
        if (ENV('MAIL_CHIMP_ENABLE')) {
            $nombres = isset($name) ? $name : " ";
            $apellidos = isset($last_name) ? $last_name : " ";


            $mailchimp = new \MailchimpMarketing\ApiClient();

            $mailchimp->setConfig([
                'apiKey' => ENV('MAIL_CHIMP_API_KEY'),
                'server' => ENV('MAIL_CHIMP_SERVER')
            ]);

            $list_id = ENV('MAIL_CHIMP_AUDIENCE_ID');

            try {
                $response = $mailchimp->lists->addListMember($list_id, [
                    "email_address" => $email,
                    "status" => "subscribed",
                    "merge_fields" => [
                        "FNAME" => $nombres,
                        "LNAME" => $apellidos
                    ]
                ]);
            } catch (\Throwable $th) {
                // throw new SomethingWentWrong($th);
            }
        } else {
            throw new NotEnable();
        }
    }


    public function subscribeContact($email)
    {
        if (ENV('MAIL_CHIMP_ENABLE')) {
            $mailchimp = new \MailchimpMarketing\ApiClient();

            $mailchimp->setConfig([
                'apiKey' => ENV('MAIL_CHIMP_API_KEY'),
                'server' => ENV('MAIL_CHIMP_SERVER')
            ]);

            $list_id = ENV('MAIL_CHIMP_AUDIENCE_ID');

            $subscriberHash = md5(strtolower($email));

            try {
                $response = $mailchimp->lists->updateListMember($list_id, $subscriberHash, ["status" => "subscribed"]);
            } catch (\Throwable $th) {
                throw new SomethingWentWrong($th);
            }
        } else {
            throw new NotEnable();
        }
    }

    public function unsubscribeContact($email)
    {
        if (ENV('MAIL_CHIMP_ENABLE')) {
            $mailchimp = new \MailchimpMarketing\ApiClient();

            $mailchimp->setConfig([
                'apiKey' => ENV('MAIL_CHIMP_API_KEY'),
                'server' => ENV('MAIL_CHIMP_SERVER')
            ]);

            $list_id = ENV('MAIL_CHIMP_AUDIENCE_ID');

            $subscriberHash = md5(strtolower($email));

            try {
                $response = $mailchimp->lists->updateListMember($listId, $subscriberHash, ["status" => "unsubscribed"]);
            } catch (\Throwable $th) {
                throw new SomethingWentWrong($th);
            }
        } else {
            throw new NotEnable();
        }
    }

    public function tagContact($email)
    {
        if (ENV('MAIL_CHIMP_ENABLE')) {
            $mailchimp = new \MailchimpMarketing\ApiClient();

            $mailchimp->setConfig([
                'apiKey' => ENV('MAIL_CHIMP_API_KEY'),
                'server' => ENV('MAIL_CHIMP_SERVER')
            ]);

            $list_id = ENV('MAIL_CHIMP_AUDIENCE_ID');

            $subscriberHash = md5(strtolower($email));

            try {
                $mailchimp->lists->updateListMemberTags($list_id, $subscriberHash, [
                    "tags" => [
                        [
                            "name" => ENV('MAIL_CHIMP_TAG'),
                            "status" => "active"
                        ]
                    ]
                ]);
            } catch (\Throwable $th) {
                throw new SomethingWentWrong($th);
            }
        } else {
            throw new NotEnable();
        }
    }

}
