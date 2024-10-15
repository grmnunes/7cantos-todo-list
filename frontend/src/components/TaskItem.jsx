import TaskButton from "./TaskButton";

export default function ({ task, completed, onComplete, onRemove }) {
  const defaultClasses = "bg-sky-100 rounded flex justify-between items-center gap-2 p-3 group hover:cursor-pointer hover:bg-slate-100 transition text-blue-500";
  const completedClasses = "flex justify-between items-center p-3 gap-2 rounded bg-blue-500 text-white";

  const completeTask = () => {
    onComplete(task.id);
  };

  const removeTask = () => {
    onRemove(task.id);
  };

  return (
    <div className={!completed ? defaultClasses : completedClasses}>
      <span className="flex-1">{task.todo}</span>
      {!completed && (
        <div className="opacity-0 group-hover:opacity-100 flex gap-2 transition-opacity">
          <TaskButton type="completed" onClick={completeTask} />
          <TaskButton onClick={removeTask} />
        </div>
      )}
    </div>
  );
}
