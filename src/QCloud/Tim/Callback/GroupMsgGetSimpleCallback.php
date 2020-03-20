<?php

namespace Extension\QCloud\Tim\Callback;

use BiuBiuJun\QCloud\Kernel\Contracts\CallbackInterface;

class GroupMsgGetSimpleCallback implements CallbackInterface
{
    /**
     * @var array
     */
    private $messages = [];

    /**
     * @var array
     */
    private $fromAccounts;

    /**
     * @var array
     */
    private $defaultFromAccount = [];

    /**
     * @param  \BiuBiuJun\QCloud\TIM\Responses\GroupOpenHttpSvc\GroupMsgGetSimpleResponse  $response
     * @return array
     */
    public function success($response)
    {
        $rspMsgList = $response->getRspMsgList();
        foreach ($rspMsgList as $item) {
            if ('@TimClient#SYSTEM' == $item['From_Account']
                || !isset($item['MsgBody'][0]['MsgType'])
                || 'TIMCustomElem' == $item['MsgBody'][0]['MsgType']) {
                continue;
            }

            $this->messages[] = [
                'from_account' => $this->getFromAccount($item['From_Account']),
                'body' => $this->formatMsgBody($item['MsgBody']),
                'random' => $item['MsgRandom'],
                'seq' => $item['MsgSeq'],
                'timestamp' => $item['MsgTimeStamp'],
            ];
        }

        return $rspMsgList[array_key_last($rspMsgList)]['MsgSeq'];
    }

    /**
     * @param $reason
     */
    public function error($reason)
    {
        // TODO: Implement error() method.
    }

    /**
     * @return string
     */
    public function getMessages()
    {
        return json_encode($this->messages);
    }

    /**
     * @param  array  $fromAccounts
     * @return $this
     */
    public function setFromAccounts(array $fromAccounts)
    {
        $this->fromAccounts = $fromAccounts;

        return $this;
    }

    /**
     * @param  array  $default
     * @return $this
     */
    public function setDefaultFromAccount(array $default)
    {
        $this->defaultFromAccount = $default;

        return $this;
    }

    /**
     * @param  string  $fromAccount
     * @return array|mixed
     */
    protected function getFromAccount(string $fromAccount)
    {
        return $this->fromAccounts[$fromAccount] ?? $this->defaultFromAccount;
    }

    /**
     * @param  array  $msgBody
     * @return array
     */
    public function formatMsgBody(array $msgBody)
    {
        $msgBody = $msgBody[0] ?? ['MsgType' => null];

        if ('TIMTextElem' == $msgBody['MsgType']) {
            return [
                'msg_content' => [
                    'text' => $msgBody['MsgContent']['Text'],
                ],
                'msg_type' => 'TIMTextElem',
            ];
        } elseif ('TIMImageElem' == $msgBody['MsgType']) {
            $msgContent = [];
            foreach ($msgBody['MsgContent']['ImageInfoArray'] as $item) {
                $msgContent[] = [
                    'height' => $item['Height'],
                    'width' => $item['Width'],
                    'url' => $item['URL'],
                    'type' => $item['Type'],
                ];
            }

            return [
                'msg_content' => [
                    'images' => $msgContent,
                ],
                'msg_type' => 'TIMImageElem',
            ];
        }
    }
}
