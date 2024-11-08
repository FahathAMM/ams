<div>
    <h1>Post Manager</h1>

    <form wire:submit.prevent="{{ $postId ? 'update' : 'create' }}">
        <input type="text" wire:model="title" placeholder="Title" required>
        <textarea wire:model="content" placeholder="Content" required></textarea>
        <button type="submit">{{ $postId ? 'Update' : 'Create' }}</button>
    </form>

    <ul>
        @foreach ($posts as $post)
            <li>
                <strong>{{ $post->employee_id }}</strong>
                <button wire:click="edit({{ $post->report_manager_id }})">Edit</button>
                <button wire:click="delete({{ $post->customer_id }})">Delete</button>
            </li>
        @endforeach
    </ul>
</div>
