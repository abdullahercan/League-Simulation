import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import {
    Box,
    Button,
    Center,
    ChakraProvider,
    Flex,
    Grid,
    Image,
    Spacer,
    Table,
    Tbody,
    Td,
    Text,
    Th,
    Thead,
    Tr
} from "@chakra-ui/react"

class Main extends Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            isLoaded: false,
            table: [],
            fixture: []
        };
    }

    playAll() {
        fetch('/api/play-all')
            .then(res => res.json())
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        table: result.data.table,
                        fixture: result.data.fixture,
                    })
                }
            )
    }

    playAllWeek(week_id) {
        fetch('/api/play-week/' + week_id)
            .then(res => res.json())
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        table: result.data.table,
                        fixture: result.data.fixture,
                    })
                }
            )
    }

    componentDidMount() {
        fetch('/api/main')
            .then(res => res.json())
            .then(
                (result) => {
                    if (result.status) {
                        this.setState({
                            isLoaded: true,
                            table: result.data.table,
                            fixture: result.data.fixture,
                        })
                    }
                }
            )
    }

    render() {
        const {error, isLoaded, table, fixture} = this.state;
        return (
            <ChakraProvider>
                <Box padding="4">
                    <Grid templateColumns="repeat(3, 1fr)" gap={6}>
                        <Box>
                            <Table variant="striped">
                                <Thead>
                                    <Tr>
                                        <Th>Team</Th>
                                        <Th>Played</Th>
                                        <Th>Won</Th>
                                        <Th>Drawn</Th>
                                        <Th>Lost</Th>
                                        <Th>Points</Th>
                                    </Tr>
                                </Thead>
                                <Tbody>
                                    {
                                        table.map((item, i) => (
                                            <Tr key={item.id}>
                                                <Td>
                                                    <Flex>
                                                        <Image boxSize="50px" mr="4" src={"/logos/" + item.logo}/>
                                                        <Text>{item.name}</Text>
                                                    </Flex>
                                                </Td>
                                                <Td>{item.played}</Td>
                                                <Td>{item.won}</Td>
                                                <Td>{item.draw}</Td>
                                                <Td>{item.lost}</Td>
                                                <Td>{item.points}</Td>
                                            </Tr>
                                        ))
                                    }
                                </Tbody>
                            </Table>
                        </Box>
                        <Box w="100%">

                            <Center mb="2">
                                <Button
                                    onClick={() => this.playAll()}
                                    size="md"
                                >
                                    Play All
                                </Button>
                            </Center>

                            {
                                fixture.map((item, i) => (
                                    <Box mb="2" p="2" border="1px" borderColor="gray.200">
                                        <Center fontWeight="semibold" bg="gray.200" p="1">{item.title} week</Center>
                                        {
                                            item.matches.map(match => (
                                                <Box>
                                                    <Grid templateColumns="repeat(2, 1fr)">
                                                        <Box p={2}>
                                                            <Flex>
                                                                <Spacer/>
                                                                <Center pr="2">{match.awayTeam}</Center>
                                                                <Image boxSize="30px" src={"/logos/" + match.awayLogo}/>
                                                            </Flex>
                                                        </Box>
                                                        <Box p={2}>
                                                            <Flex>
                                                                <Image boxSize="30px" src={"/logos/" + match.homeLogo}/>
                                                                <Center pl="2">{match.homeTeam}</Center>
                                                                <Spacer/>
                                                            </Flex>
                                                        </Box>
                                                    </Grid>
                                                </Box>
                                            ))
                                        }
                                        <Center mt="2">
                                            <Button
                                                onClick={() => this.playAllWeek(item.id)}
                                                size="xs"
                                                loadingText="playing"
                                            >
                                                Play Week
                                            </Button>
                                        </Center>
                                    </Box>
                                ))
                            }

                        </Box>
                        <Box w="100%">
                            <Center mb="3">
                                <Box>Week Predictions of Championship</Box>
                            </Center>
                            <Box>
                                <Table variant="striped">
                                    <Tbody>
                                        <Tr>
                                            <Td>Manchester City</Td>
                                            <Td>0%</Td>
                                        </Tr>
                                    </Tbody>
                                </Table>
                            </Box>
                        </Box>
                    </Grid>
                </Box>
            </ChakraProvider>
        )
    }
}

if (document.getElementById('app')) {
    ReactDOM.render(<Main/>, document.getElementById('app'));
}
