// Sample data for the travel planner
const travelData = {
    destinations: [
        {
            id: 1,
            name: 'Paris',
            country: 'France',
            image: 'paris',
            description: 'The city of love and lights, famous for its art, fashion, and cuisine.',
            rating: 4.8,
            attractions: 12,
            accommodations: 45,
            events: 8,
            price: 1200,
            category: 'city'
        },
        {
            id: 2,
            name: 'Bali',
            country: 'Indonesia',
            image: 'bali',
            description: 'Tropical paradise with beautiful beaches, temples, and vibrant culture.',
            rating: 4.9,
            attractions: 15,
            accommodations: 38,
            events: 6,
            price: 800,
            category: 'beach'
        },
        {
            id: 3,
            name: 'Tokyo',
            country: 'Japan',
            image: 'tokyo',
            description: 'A bustling metropolis blending traditional culture with modern technology.',
            rating: 4.7,
            attractions: 20,
            accommodations: 52,
            events: 12,
            price: 1500,
            category: 'city'
        },
        {
            id: 4,
            name: 'Swiss Alps',
            country: 'Switzerland',
            image: 'alps',
            description: 'Breathtaking mountain scenery perfect for adventure and relaxation.',
            rating: 4.9,
            attractions: 8,
            accommodations: 25,
            events: 4,
            price: 1800,
            category: 'mountain'
        }
    ],

    bundles: [
        {
            id: 1,
            name: 'European Dream',
            destinations: ['Paris', 'Rome', 'Barcelona'],
            duration: '10 days',
            price: 2500,
            savings: 500,
            features: [
                '3-star hotels',
                'Flight included',
                'City tours',
                'Breakfast included'
            ]
        },
        {
            id: 2,
            name: 'Asian Adventure',
            destinations: ['Tokyo', 'Bangkok', 'Bali'],
            duration: '14 days',
            price: 3200,
            savings: 700,
            features: [
                '4-star hotels',
                'All flights included',
                'Cultural experiences',
                'Some meals included'
            ]
        }
    ],

    userTrips: [
        {
            id: 1,
            name: 'Summer Europe Tour',
            destinations: ['Paris', 'Rome', 'Amsterdam'],
            startDate: '2024-07-15',
            endDate: '2024-07-25',
            status: 'upcoming',
            accommodations: 3,
            transport: 4,
            events: 8,
            budget: 3000
        },
        {
            id: 2,
            name: 'Japan Cultural Trip',
            destinations: ['Tokyo', 'Kyoto', 'Osaka'],
            startDate: '2023-11-10',
            endDate: '2023-11-20',
            status: 'past',
            accommodations: 4,
            transport: 6,
            events: 12,
            budget: 2800
        }
    ]
};

// Export for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = travelData;
}