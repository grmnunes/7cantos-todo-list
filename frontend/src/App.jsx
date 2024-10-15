import React, { useState, useEffect } from "react"
import Container from "./components/Container"
import TaskItem from "./components/TaskItem"
import AddTask from "./components/AddTask"
import taskData from "./services/todos.json"

function App() {
    const [tasks, setTask] = useState([]);
    const [loading, setLoading] = useState(false);
    const [useLocalData, setUseLocalData] = useState(true);

    const handleComplete = (id) => {
        setTask(
            tasks.map((task) => (task.id === id ? { ...task, completed: true } : task))
        );
    };

    const handleRemove = (id) => {
        setTask(tasks.filter((task) => task.id !== id));
    };

    const handleAdd = (task) => {
        task.id = Date.now()
        setTask([...tasks, task]);
    };

    const toggleDataSource = () => {
        setUseLocalData((prev) => !prev);
    };

    const fetchTasksFromAPI = async () => {
        setLoading(true);
        try {
            const response = await fetch("https://dummyjson.com/todos");
            const data = await response.json();
            setTask(data.todos);
        } catch (error) {
            console.error("Error fetching tasks:", error);
        } finally {
            setLoading(false);
        }
    };

    const loadLocalTasks = () => {
        setLoading(true);
        setTask(taskData.todos);
        setLoading(false);
    };

    useEffect(() => {
        if (useLocalData) {
            loadLocalTasks();
        } else {
            fetchTasksFromAPI();
        }
    }, [useLocalData]);

    return (
        <div className="App flex flex-col bg-gradient-to-r from-blue-600 to-teal-300 justify-center items-center h-screen w-screen">
            <button
                onClick={toggleDataSource}
                className="p-2 bg-blue-900 text-white mt-4 rounded mb-4"
                >
                {useLocalData ? "Carregar arquivos via API" : "Carregar arquivos via arquivo"}
            </button>
            <Container>
                <div className="flex flex-col flex-1 p-5 items-top gap-5">
                <AddTask onAdd={handleAdd} />

                {tasks
                    .filter((task) => !task.completed)
                    .map((task, index) => (
                        <TaskItem
                            key={task.id}
                            task={task}
                            onComplete={handleComplete}
                            onRemove={handleRemove}
                        />
                    ))
                }

                <div className="w-full border border-blue-600"></div>

                {tasks
                    .filter((task) => task.completed)
                    .map((task, index) => (
                        <TaskItem key={task.id} task={task} completed={task.completed} />
                    ))
                }
                </div>
            </Container>
        </div>
    );
}

export default App;
