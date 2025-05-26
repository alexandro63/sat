$(document).ready(function () {

    const userGroups = [
        { id: 'studentsCount', value: activeStudents, color: '#4CAF50' },
        { id: 'teachersCount', value: activeTeachers, color: '#2196F3' },
        { id: 'administrativeCount', value: activeAdministrative, color: '#FF9800' },
        { id: 'usersCount', value: activeUsers, color: '#9C27B0' }
    ];

    const createCircle = ({ id, value, color }) => {
        if (typeof value !== 'number') return;

        Circles.create({
            id: id,
            radius: 45,
            value: value,
            maxValue: 100,
            width: 7,
            text: value,
            colors: ['#f1f1f1', color],
            duration: 400,
            wrpClass: 'circles-wrp',
            textClass: 'circles-text',
            styleWrapper: true,
            styleText: true
        });
    };

    userGroups.forEach(createCircle);
});
