<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\ChannelSubscriber;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index($channel_id = null) {
        $locked = null;
        if ($locked == 'locked') {
            $locked == true;
        }
        $user = Auth::user();
        $all_channels = Channel::all();
        $channels = [];
        foreach ($all_channels as $channel) {
            $lastMessage = Message::where('channel_id', $channel->id)->orderBy('created_at', 'desc')->first();
            if ($lastMessage) {
                $channel->last_message = $lastMessage;
            }
            $is_subscriber = ChannelSubscriber::where('channel_id', $channel->id)->where('user_id', $user->id)->first();
            if($is_subscriber) {
                $channels[] = $channel;
            }
        }

        $channels = collect($channels)->sortByDesc(function ($channel) {
            return optional($channel->last_message)->created_at ?? null;
        })->values()->all();

        $subscribers = ChannelSubscriber::where('channel_id', $channel_id)->where('user_id', '!=', $user->id)->get();
        $current_channel = Channel::find($channel_id);
        $messages = Message::where('channel_id',$channel_id)->get();
        $data = [
            'locked' => $locked,
            'my_username' => $user->user_name,
            'my_user_id' => $user->id,
            'subscribers' => $subscribers,
            'channel_id' => $channel_id,
            'channels' => $channels,
        ];
        if ($current_channel) {
            $data['current_channel'] = $current_channel;
            $data['messages'] = $messages;
        }
        return view('backend.pages.message.index', $data);
    }

    public function messageSave(Request $request) {
        $message = new Message();

        $message->channel_id = $request->channel_id;
        $message->user_id = Auth::user()->id;
        $message->message = $request->message;

        $message->save();

        $response = [
            'success' => true,
            'body' => $message
        ];
        return response()->json($response);
    }

    public function reloadChannelContainer() {
        $user = Auth::user();
        $all_channels = Channel::all();
        $channels = [];
        foreach ($all_channels as $channel) {
            $lastMessage = Message::where('channel_id', $channel->id)->orderBy('created_at', 'desc')->first();
            if ($lastMessage) {
                $channel->last_message = $lastMessage;
            }
            $is_subscriber = ChannelSubscriber::where('channel_id', $channel->id)->where('user_id', $user->id)->first();
            if($is_subscriber) {
                $channels[] = $channel;
            }
        }

        $channels = collect($channels)->sortByDesc(function ($channel) {
            return optional($channel->last_message)->created_at ?? null;
        })->values()->all();
        $data = [
            'channels' => $channels,
            'my_user_id' => $user->id
        ];

        return view('frontend.pages.message.message-users', $data);
    }
}
