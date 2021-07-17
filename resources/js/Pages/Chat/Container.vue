<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <selection
                    v-if="currentRoom.id"
                    :rooms="chatRooms"
                    :currentRoom="currentRoom"
                    v-on:room-changed="setRoom($event)"
                />
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <message-container :messages="messages" />
                    <input-message
                        :room="currentRoom"
                        v-on:message-sent="getMessages()"
                    />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import MessageContainer from './Message/MessageContainer'
import InputMessage from './Message/Input'
import Selection from './ChatRoom/Selection'

export default {
    components: {
        AppLayout,
        MessageContainer,
        InputMessage,
        Selection
    },
    data() {
        return {
            chatRooms: [],
            currentRoom: [],
            messages: []
        }
    },
    watch: {
        currentRoom(room, oldRoom) {
            if (oldRoom.id) {
                this.disconnect(oldRoom);
            }
            this.connect();
        }
    },
    methods: {
        connect() {
            if (this.currentRoom.id) {
                let vm = this;
                this.getMessages();
                window.Echo.private('chat.' + this.currentRoom.id)
                    .listen('.message.new', e => {
                        vm.getMessages();
                    });
            }
        },
        disconnect(room) {
            window.Echo.leave('chat.' + room.id);
        },
        getRooms() {
            axios.get('/api/chat/rooms')
                .then(response => {
                    this.chatRooms = response.data;
                    this.setRoom(response.data[0]);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        setRoom(room) {
            this.currentRoom = room;
        },
        getMessages() {
            axios.get('/api/chat/room/' + this.currentRoom.id + '/messages')
                .then(response => {
                    this.messages = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    created() {
        this.getRooms();
    }
}
</script>
