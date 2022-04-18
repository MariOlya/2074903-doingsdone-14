<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post" autocomplete="off">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
        <a href="/" class="tasks-switch__item">Повестка дня</a>
        <a href="/" class="tasks-switch__item">Завтра</a>
        <a href="/" class="tasks-switch__item">Просроченные</a>
    </nav>

    <label class="checkbox">
        <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
        <input class="checkbox__input visually-hidden show_completed" type="checkbox"
        <?php if ($show_complete_tasks): ?> checked <?php endif; ?> >
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
<?php foreach ($tasks as $task): ?>
    <?php if (!$show_complete_tasks and $task['done']): continue ?><?php endif; ?>
    <?php if ($task['done']): ?>
    <tr class="tasks__item task task--completed">
    <?php endif; ?>
        <td class="task__select">
            <label class="checkbox task__checkbox">
                <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                <span class="checkbox__text"><?= htmlspecialchars($task['to_do']) ?></span>
            </label>
        </td>

        <td class="task__file">
            <a class="download-link" href="#"></a>
        </td>

        <td class="task__date"><?= htmlspecialchars($task['deadline']) ?></td>
    </tr>
<?php endforeach; ?>
</table>