<template>
    <div class="h-10 m-1">
        <div class="grid grid-cols-6 border-t-2 border-gray-600">
            <input
                type="text"
                v-model="message"
                @keyup.enter="sendMessage()"
                placeholder="Say something..."
                class="col-span-5 border-none outline-none p-1"
            />
            <button
                @click="sendMessage()"
                class="place-self-end bg-gray-500 hover:bg-blue-700 p-1 mt-1 rounded text-white"
            >
                Send
            </button>
        </div>
    </div>
</template>

<script>
    import Input from '../../../Jetstream/Input'

    export default {
        components: { Input },
        props: ['room'],
        data() {
            return {
                message: '',
            }
        },
        methods: {
            sendMessage() {
                if (this.message === '') {
                    return;
                }

                axios.post('/api/chat/room/' + this.room.id + '/message', {
                    message: this.message
                })
                    .then(response => {
                        if (response.status === 201) {
                            this.$emit('message-sent');
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
                this.message = '';
            }
        }
    }
</script>
