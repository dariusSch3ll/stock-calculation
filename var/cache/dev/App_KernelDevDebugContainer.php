<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerCT6rC4L\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerCT6rC4L/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerCT6rC4L.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerCT6rC4L\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerCT6rC4L\App_KernelDevDebugContainer([
    'container.build_hash' => 'CT6rC4L',
    'container.build_id' => '766f1a4d',
    'container.build_time' => 1688624624,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerCT6rC4L');
