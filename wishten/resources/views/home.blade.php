@extends('layouts.app')

@section('title', 'Home')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/homeStyle.css') }}">
@endsection

@section('home')
    <div class="home-view">
        <video id="back-video" preload="auto" autoplay loop muted>
            <source src="{{ asset('background/background.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="home-content">
            <h1>WISHTEN</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium tempora necessitatibus suscipit placeat, autem voluptas ducimus eos. Atque illo odit excepturi tempore velit in, architecto aspernatur pariatur repellat autem unde.
            Error, eius delectus! Reprehenderit corporis voluptates ipsa quo eaque? Commodi deleniti dicta, voluptatem unde labore, ea vitae odio accusantium non saepe numquam architecto omnis ipsam adipisci consequatur minus ratione vero.
            Obcaecati quaerat dolor non dolores et, omnis odio enim, minima nam est eos soluta quasi eligendi reprehenderit unde sunt eaque modi atque aliquam nisi blanditiis. Amet aliquam doloremque ut fuga.
            Omnis, aliquid. Nulla ullam mollitia sunt rem temporibus error aliquid nisi numquam, natus possimus harum odit quam cupiditate autem distinctio labore magnam esse maxime, non ea nostrum neque? Eveniet, quod!
            Perferendis vel itaque quaerat error! Ipsa laborum ex laudantium nisi tempora porro libero praesentium pariatur. Laudantium nisi commodi nemo a deleniti est corrupti eligendi eum? Impedit quibusdam odio temporibus accusantium.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium tempora necessitatibus suscipit placeat, autem voluptas ducimus eos. Atque illo odit excepturi tempore velit in, architecto aspernatur pariatur repellat autem unde.
            Error, eius delectus! Reprehenderit corporis voluptates ipsa quo eaque? Commodi deleniti dicta, voluptatem unde labore, ea vitae odio accusantium non saepe numquam architecto omnis ipsam adipisci consequatur minus ratione vero.
            Obcaecati quaerat dolor non dolores et, omnis odio enim, minima nam est eos soluta quasi eligendi reprehenderit unde sunt eaque modi atque aliquam nisi blanditiis. Amet aliquam doloremque ut fuga.
            Omnis, aliquid. Nulla ullam mollitia sunt rem temporibus error aliquid nisi numquam, natus possimus harum odit quam cupiditate autem distinctio labore magnam esse maxime, non ea nostrum neque? Eveniet, quod!
            Perferendis vel itaque quaerat error! Ipsa laborum ex laudantium nisi tempora porro libero praesentium pariatur. Laudantium nisi commodi nemo a deleniti est corrupti eligendi eum? Impedit quibusdam odio temporibus accusantium.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium tempora necessitatibus suscipit placeat, autem voluptas ducimus eos. Atque illo odit excepturi tempore velit in, architecto aspernatur pariatur repellat autem unde.
            Error, eius delectus! Reprehenderit corporis voluptates ipsa quo eaque? Commodi deleniti dicta, voluptatem unde labore, ea vitae odio accusantium non saepe numquam architecto omnis ipsam adipisci consequatur minus ratione vero.
            Obcaecati quaerat dolor non dolores et, omnis odio enim, minima nam est eos soluta quasi eligendi reprehenderit unde sunt eaque modi atque aliquam nisi blanditiis. Amet aliquam doloremque ut fuga.
            Omnis, aliquid. Nulla ullam mollitia sunt rem temporibus error aliquid nisi numquam, natus possimus harum odit quam cupiditate autem distinctio labore magnam esse maxime, non ea nostrum neque? Eveniet, quod!
            Perferendis vel itaque quaerat error! Ipsa laborum ex laudantium nisi tempora porro libero praesentium pariatur. Laudantium nisi commodi nemo a deleniti est corrupti eligendi eum? Impedit quibusdam odio temporibus accusantium.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium tempora necessitatibus suscipit placeat, autem voluptas ducimus eos. Atque illo odit excepturi tempore velit in, architecto aspernatur pariatur repellat autem unde.
            Error, eius delectus! Reprehenderit corporis voluptates ipsa quo eaque? Commodi deleniti dicta, voluptatem unde labore, ea vitae odio accusantium non saepe numquam architecto omnis ipsam adipisci consequatur minus ratione vero.
            Obcaecati quaerat dolor non dolores et, omnis odio enim, minima nam est eos soluta quasi eligendi reprehenderit unde sunt eaque modi atque aliquam nisi blanditiis. Amet aliquam doloremque ut fuga.
            Omnis, aliquid. Nulla ullam mollitia sunt rem temporibus error aliquid nisi numquam, natus possimus harum odit quam cupiditate autem distinctio labore magnam esse maxime, non ea nostrum neque? Eveniet, quod!
            Perferendis vel itaque quaerat error! Ipsa laborum ex laudantium nisi tempora porro libero praesentium pariatur. Laudantium nisi commodi nemo a deleniti est corrupti eligendi eum? Impedit quibusdam odio temporibus accusantium.</p>
        </div>
    </div>
@endsection

