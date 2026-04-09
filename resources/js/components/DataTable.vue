<template>
    <div class="rounded-md border border-border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-muted text-muted-foreground">
                <slot name="head" />
            </thead>
            <tbody>
                <slot name="body" />
            </tbody>
        </table>
    </div>
</template>